<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\PlaygroundFormSubmissionMail;
use App\Mail\PlaygroundVerificationMail;

class PlaygroundController extends Controller
{
    /**
     * Show the playground page.
     */
    public function index()
    {
        return view('pages.playground');
    }

    /**
     * GET /f/{email}
     * Shown when someone visits the endpoint directly in a browser.
     * If email not verified → show activation instructions.
     * If verified → show a simple "endpoint active" page.
     */
    public function formEndpointInfo(string $email)
    {
        $email    = strtolower($email);
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);
        $verified = $data && ($data['verified'] ?? false);

        return view('pages.form-endpoint-info', compact('email', 'verified'));
    }

    /**
     * POST /f/{email}
     * The standalone form endpoint — works like formsubmit.co.
     * Any HTML form with action="https://yourapp.com/f/your@email.com" hits this.
     */
    public function formEndpoint(Request $request, string $email)
    {
        $email = strtolower($email);

        // Check email is verified
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        if (!$data || empty($data['verified'])) {
            // Not verified yet — send verification email automatically (first time)
            if (!$data) {
                $this->sendVerification($email);
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not verified. Check your inbox for a verification link.',
                ], 403);
            }

            // Redirect to activation page
            return redirect()->route('form.info', $email)
                ->with('warning', 'Please verify your email before submissions are accepted.');
        }

        // Collect all submitted fields (exclude internal Laravel fields)
        $skip = ['_token', '_method', '_next', '_subject', '_captcha'];
        $fields = [];
        foreach ($request->except($skip) as $key => $value) {
            if (!str_starts_with($key, '_')) {
                $fields[$key] = $value;
            }
        }

        // Build formData for the email
        $formData = [
            'name'            => $fields['name'] ?? $fields['full_name'] ?? 'Anonymous',
            'sender_email'    => $fields['email'] ?? $fields['email_address'] ?? 'noreply@unknown.com',
            'message'         => $fields['message'] ?? $fields['body'] ?? json_encode($fields),
            'recipient_email' => $email,
            'submitted_at'    => now()->format('Y-m-d H:i:s'),
            'app_url'         => config('app.url'),
            'extra_fields'    => array_filter($fields, fn($k) =>
                !in_array($k, ['name', 'full_name', 'email', 'email_address', 'message', 'body']),
                ARRAY_FILTER_USE_KEY
            ),
        ];

        // Handle file uploads
        $fileAttachments = [];
        foreach ($request->allFiles() as $file) {
            if (!is_array($file)) $file = [$file];
            foreach ($file as $f) {
                $fileAttachments[] = [
                    'file' => $f->path(),
                    'name' => $f->getClientOriginalName(),
                    'mime' => $f->getMimeType(),
                ];
            }
        }

        try {
            Mail::to($email)->send(new PlaygroundFormSubmissionMail($formData, $fileAttachments));

            Log::info('Form endpoint submission', ['recipient' => $email, 'fields' => array_keys($fields)]);

        } catch (\Exception $e) {
            Log::error('Form endpoint submission failed: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Failed to send.'], 500);
            }

            return redirect()->back()->with('error', 'Failed to send your message. Please try again.');
        }

        // Determine where to redirect after success
        $next = $request->input('_next', route('form.submitted'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Submission received!']);
        }

        return redirect($next)->with('success', 'Your message has been sent!');
    }

    /**
     * GET /form-submitted
     * Default success page after a standalone form submission.
     */
    public function formSubmitted()
    {
        return view('pages.form-submitted');
    }

    /**
     * Send a verification email to the given address.
     */
    protected function sendVerification(string $email): void
    {
        $token    = Str::random(32);
        $cacheKey = 'playground_verify_' . md5($email);

        Cache::put($cacheKey, ['token' => $token, 'verified' => false], now()->addMinutes(15));

        $verifyUrl = route('playground.confirm-email', ['email' => $email, 'token' => $token]);

        try {
            Mail::to($email)->send(new PlaygroundVerificationMail($email, $verifyUrl));
        } catch (\Exception $e) {
            Log::error('Auto-verification email failed: ' . $e->getMessage());
        }
    }

    // =========================================================
    //  Playground page routes (existing)
    // =========================================================

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid email address.'], 422);
        }

        $email        = strtolower($request->email);
        $limitKey     = 'playground_verify_limit_' . md5($email);
        $attempts     = Cache::get($limitKey, 0);

        if ($attempts >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Too many verification attempts. Please wait 10 minutes.',
            ], 429);
        }

        Cache::put($limitKey, $attempts + 1, now()->addMinutes(10));

        $this->sendVerification($email);

        return response()->json(['success' => true, 'message' => 'Verification email sent.']);
    }

    public function confirmEmail(Request $request)
    {
        $email    = strtolower($request->query('email', ''));
        $token    = $request->query('token', '');
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        if (!$data || $data['token'] !== $token) {
            return view('pages.playground-verify-result', [
                'success' => false,
                'message' => 'This verification link is invalid or has expired.',
                'email'   => $email,
            ]);
        }

        Cache::put($cacheKey, array_merge($data, ['verified' => true]), now()->addMinutes(60));

        return view('pages.playground-verify-result', [
            'success' => true,
            'message' => 'Your email has been verified! You can now close this tab and submit the form.',
            'email'   => $email,
        ]);
    }

    public function checkVerified(Request $request)
    {
        $email    = strtolower($request->query('email', ''));
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        return response()->json(['verified' => $data && ($data['verified'] ?? false)]);
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|min:2|max:255',
            'email'           => 'required|email|max:255',
            'message'         => 'required|string|min:5',
            'recipient_email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $recipientEmail = strtolower($request->recipient_email);
        $cacheKey       = 'playground_verify_' . md5($recipientEmail);
        $data           = Cache::get($cacheKey);

        if (!$data || empty($data['verified'])) {
            return response()->json([
                'success' => false,
                'message' => '⚠️ Recipient email not verified. Please verify it first.',
            ], 403);
        }

        try {
            $formData = [
                'name'            => $request->name,
                'sender_email'    => $request->email,
                'message'         => $request->message,
                'recipient_email' => $recipientEmail,
                'submitted_at'    => now()->format('Y-m-d H:i:s'),
                'app_url'         => config('app.url'),
                'extra_fields'    => array_filter(
                    $request->except(['name', 'email', 'message', 'recipient_email', '_token', '_method']),
                    fn($k) => !str_starts_with($k, '_'),
                    ARRAY_FILTER_USE_KEY
                ),
            ];

            $fileAttachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $fileAttachments[] = [
                        'file' => $file->path(),
                        'name' => $file->getClientOriginalName(),
                        'mime' => $file->getMimeType(),
                    ];
                }
            }

            Mail::to($recipientEmail)->send(new PlaygroundFormSubmissionMail($formData, $fileAttachments));

            Log::info('Playground submission sent', ['recipient' => $recipientEmail]);

            return response()->json(['success' => true, 'message' => '✅ Message sent successfully!']);

        } catch (\Exception $e) {
            Log::error('Playground submission failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '❌ Failed to send: ' . $e->getMessage(),
            ], 500);
        }
    }
}