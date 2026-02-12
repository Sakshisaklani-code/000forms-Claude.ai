<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    /**
     * Show dashboard home.
     */
    public function index()
    {
        $user = Auth::user();
        $forms = $user->forms()
            ->withCount(['submissions as unread_count' => function ($query) {
                $query->where('is_spam', false)->where('is_read', false);
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_forms' => $forms->count(),
            'total_submissions' => $forms->sum('submission_count'),
            'total_unread' => $forms->sum('unread_count'),
            'forms_this_month' => $user->forms()
                ->where('created_at', '>=', now()->startOfMonth())
                ->count(),
        ];

        $chartData = $this->prepareChartData($user);

        return view('dashboard.index', compact('forms', 'stats', 'chartData'));
    }

    /**
     * Prepare chart data for forms created over time.
     */
    private function prepareChartData($user)
    {
        $formsGrouped = $user->forms()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');
        
        $chartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dateKey = $date->format('Y-m-d');
            
            $chartData[] = [
                'label' => $date->format('M j'),
                'count' => $formsGrouped->get($dateKey)?->count ?? 0,
            ];
        }
        
        return $chartData;
    }

    /**
     * Show form creation page.
     */
    public function createForm()
    {
        return view('dashboard.forms.create');
    }

    /**
     * Store new form.
     */
    public function storeForm(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'cc_emails' => 'nullable|string|max:500',
            'redirect_url' => 'nullable|url|max:500',
            'success_message' => 'nullable|string|max:500',
            'auto_response_enabled' => 'boolean',
            'auto_response_message' => 'nullable|string',
        ]);

        // Process CC emails
        $ccEmails = null;
        if ($request->filled('cc_emails')) {
            $ccEmails = array_map('trim', explode(',', $request->input('cc_emails')));
            $ccEmails = array_filter($ccEmails, function($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });
            $ccEmails = array_values($ccEmails);
        }

        $form = Auth::user()->forms()->create([
            'name' => $request->input('name'),
            'recipient_email' => $request->input('recipient_email'),
            'cc_emails' => $ccEmails,
            'redirect_url' => $request->input('redirect_url'),
            'success_message' => $request->input('success_message', 'Thank you for your submission!'),
            'auto_response_enabled' => $request->boolean('auto_response_enabled'),
            'auto_response_message' => $request->input('auto_response_message'),
            'email_notifications' => true,
            'store_submissions' => true,
            'honeypot_enabled' => true,
            'status' => 'active',
        ]);

        // Send verification email
        $this->sendVerificationEmail($form);

        return redirect()->route('dashboard.forms.show', $form->id)
            ->with('message', 'Form created! Please verify the recipient email address.');
    }

    /**
     * Show form details.
     */
    public function showForm(string $id)
    {
        $form = Auth::user()->forms()->findOrFail($id);

        $submissions = $form->submissions()
            ->where('is_spam', false)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // 📊 Line Graph Data (Last 7 Days)
        $dailySubmissions = $form->submissions()
            ->where('is_spam', false)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $lineLabels = [];
        $lineData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $lineLabels[] = now()->subDays($i)->format('M d');
            $lineData[] = $dailySubmissions->firstWhere('date', $date)->count ?? 0;
        }

        // 📊 Bar Graph Data
        $validCount = $form->submissions()->where('is_spam', false)->count();
        $spamCount = $form->submissions()->where('is_spam', true)->count();

        return view('dashboard.forms.show', compact(
            'form',
            'submissions',
            'lineLabels',
            'lineData',
            'validCount',
            'spamCount'
        ));
    }
    
    /**
     * Show form settings.
     */
    public function editForm(string $id)
    {
        $form = Auth::user()->forms()->findOrFail($id);
        return view('dashboard.forms.edit', compact('form'));
    }

    /**
     * Update form settings.
     */
    public function updateForm(Request $request, string $id)
    {
        $form = Auth::user()->forms()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'cc_emails' => 'nullable|string|max:500',
            'redirect_url' => 'nullable|url|max:500',
            'success_message' => 'nullable|string|max:500',
            'status' => 'required|in:active,paused',
            'honeypot_enabled' => 'boolean',
            'email_notifications' => 'boolean',
            'store_submissions' => 'boolean',
            'auto_response_enabled' => 'boolean',
            'auto_response_message' => 'nullable|string',
        ]);

        // Process CC emails
        $ccEmails = null;
        if ($request->filled('cc_emails')) {
            $ccEmails = array_map('trim', explode(',', $request->input('cc_emails')));
            $ccEmails = array_filter($ccEmails, function($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            });
            $ccEmails = array_values($ccEmails);
        }

        // Check if email changed
        $emailChanged = $form->recipient_email !== $request->input('recipient_email');

        $form->update([
            'name' => $request->input('name'),
            'recipient_email' => $request->input('recipient_email'),
            'cc_emails' => $ccEmails,
            'redirect_url' => $request->input('redirect_url'),
            'success_message' => $request->input('success_message', 'Thank you for your submission!'),
            'status' => $request->input('status'),
            'honeypot_enabled' => $request->boolean('honeypot_enabled'),
            'email_notifications' => $request->boolean('email_notifications'),
            'store_submissions' => $request->boolean('store_submissions'),
            'auto_response_enabled' => $request->boolean('auto_response_enabled'),
            'auto_response_message' => $request->input('auto_response_message'),
            'email_verified' => $emailChanged ? false : $form->email_verified,
        ]);

        // Resend verification if email changed
        if ($emailChanged) {
            $form->update([
                'email_verification_token' => Str::random(64),
            ]);
            $this->sendVerificationEmail($form);
            
            return redirect()->route('dashboard.forms.show', $form->id)
                ->with('message', 'Form updated! Please verify the new email address.');
        }

        return redirect()->route('dashboard.forms.show', $form->id)
            ->with('message', 'Form settings updated.');
    }

    /**
     * Delete form.
     */
    public function destroyForm(string $id)
    {
        $form = Auth::user()->forms()->findOrFail($id);
        $form->delete();

        return redirect()->route('dashboard')
            ->with('message', 'Form deleted.');
    }

    /**
     * Show submission details.
     */
    public function showSubmission(string $formId, string $submissionId)
    {
        $form = Auth::user()->forms()->findOrFail($formId);
        $submission = $form->submissions()->findOrFail($submissionId);

        // Mark as read
        $submission->markAsRead();

        return view('dashboard.submissions.show', compact('form', 'submission'));
    }

    /**
     * Delete submission.
     */
    public function destroySubmission(string $formId, string $submissionId)
    {
        $form = Auth::user()->forms()->findOrFail($formId);
        $submission = $form->submissions()->findOrFail($submissionId);
        $submission->delete();

        return redirect()->route('dashboard.forms.show', $form->id)
            ->with('message', 'Submission deleted.');
    }

    /**
     * Mark submission as spam.
     */
    public function markAsSpam(string $formId, string $submissionId)
    {
        $form = Auth::user()->forms()->findOrFail($formId);
        $submission = $form->submissions()->findOrFail($submissionId);
        $submission->markAsSpam('Marked by user');

        return back()->with('message', 'Submission marked as spam.');
    }

    /**
     * Export submissions as CSV.
     */
    public function exportSubmissions(string $id)
    {
        $form = Auth::user()->forms()->findOrFail($id);
        $submissions = $form->submissions()
            ->where('is_spam', false)
            ->orderBy('created_at', 'desc')
            ->get();

        // Collect all unique field names
        $fields = [];
        foreach ($submissions as $submission) {
            $fields = array_merge($fields, array_keys($submission->data));
        }
        $fields = array_unique($fields);

        // Build CSV
        $csv = fopen('php://temp', 'r+');
        
        // Header row
        fputcsv($csv, array_merge(['Submitted At', 'IP Address'], $fields));

        // Data rows
        foreach ($submissions as $submission) {
            $row = [
                $submission->created_at->toDateTimeString(),
                $submission->ip_address,
            ];
            foreach ($fields as $field) {
                $row[] = $submission->data[$field] ?? '';
            }
            fputcsv($csv, $row);
        }

        rewind($csv);
        $content = stream_get_contents($csv);
        fclose($csv);

        $filename = "{$form->name}_submissions_" . now()->format('Y-m-d') . '.csv';

        return response($content)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }

    /**
     * Resend verification email.
     */
    public function resendVerification(string $id)
    {
        $form = Auth::user()->forms()->findOrFail($id);

        if ($form->email_verified) {
            return back()->with('message', 'Email is already verified.');
        }

        // Generate new token
        $form->update([
            'email_verification_token' => Str::random(64),
        ]);

        $this->sendVerificationEmail($form);

        return back()->with('message', 'Verification email sent.');
    }

    /**
     * Send email verification.
     */
    protected function sendVerificationEmail(Form $form): void
    {
        Mail::to($form->recipient_email)->send(
            new \App\Mail\EmailVerificationMail($form)
        );
    }
}