<?php

namespace App\Http\Controllers;

use App\Mail\FormSubmissionMail;
use App\Models\Form;
use App\Models\Submission;
use App\Services\SpamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FormSubmissionController extends Controller
{
    protected SpamDetectionService $spamDetector;

    public function __construct(SpamDetectionService $spamDetector)
    {
        $this->spamDetector = $spamDetector;
    }

    // =========================================================================
    // MAIN SUBMIT ENTRY POINT
    // =========================================================================

    public function submit(Request $request, string $slug)
    {
        $form = Form::where('slug', $slug)->first();

        if (!$form) {
            return $this->errorResponse($request, 'Form not found', 404);
        }

        // -----------------------------------------------------------------
        // PAUSED FORM
        // Always return the "disabled" error to the visitor.
        // Optionally store in archive (never inbox, never spam).
        // This block runs before EVERYTHING else so there is zero chance
        // a paused-form submission leaks into inbox or spam.
        // -----------------------------------------------------------------
        if ($form->status === 'paused') {
            if ($form->archive_when_paused ?? true) {
                $this->storeArchivedSubmission($request, $form);
            }

            // Visitor always sees the error — regardless of archive toggle
            return $this->pausedResponse($request);
        }

        // -----------------------------------------------------------------
        // EMAIL NOT VERIFIED
        // -----------------------------------------------------------------
        if (!$form->email_verified) {
            return $this->errorResponse($request, 'Form email not verified', 403);
        }

        // -----------------------------------------------------------------
        // FORM NOT ACTIVE (disabled / over limit / etc.)
        // -----------------------------------------------------------------
        if (!$form->canAcceptSubmissions()) {
            return $this->errorResponse($request, 'Form is not accepting submissions', 403);
        }

        // -----------------------------------------------------------------
        // DOMAIN RESTRICTION
        // -----------------------------------------------------------------
        if (!$form->isDomainAllowed($request->header('Referer'))) {
            return $this->errorResponse($request, 'Submissions from this domain are not allowed', 403);
        }

        // -----------------------------------------------------------------
        // PARSE SUBMISSION DATA
        // -----------------------------------------------------------------
        $allData        = $request->except(['_token']);
        $internalFields = ['_gotcha', '_honeypot', '_next', '_format', '_form_load_time', '_cc'];
        $submissionData = [];

        foreach ($allData as $key => $value) {
            if (!in_array($key, $internalFields) && $key !== $form->honeypot_field) {
                if (!$request->hasFile($key)) {
                    $submissionData[$key] = $value;
                }
            }
        }

        // -----------------------------------------------------------------
        // FILE UPLOADS
        // -----------------------------------------------------------------
        [$uploadedFiles, $uploadMetadata, $fileError] = $this->handleFileUploads($request, $form, $internalFields);

        if ($fileError !== null) {
            return $this->errorResponse($request, $fileError, 422);
        }

        Log::info('Total files uploaded: ' . count($uploadedFiles));

        // -----------------------------------------------------------------
        // AUTO-RESPONSE (before spam check so visitor always gets it)
        // -----------------------------------------------------------------
        $visitorEmail = null;
        if ($form->auto_response_enabled) {
            $visitorEmail = $form->getVisitorEmail($submissionData);
            if ($visitorEmail) {
                $this->sendAutoResponse($form, $submissionData);
            } else {
                Log::warning('Auto-response: No email field found in submission');
            }
        }

        // -----------------------------------------------------------------
        // SPAM CHECK
        // -----------------------------------------------------------------
        $spamCheck = $this->spamDetector->isSpam($form, $request, $allData);

        // -----------------------------------------------------------------
        // STORE SUBMISSION
        // Active form submissions go to inbox (is_spam=false, is_archived=false)
        // or spam (is_spam=true, is_archived=false).
        // is_archived is ALWAYS false here — only paused-form subs are archived.
        // -----------------------------------------------------------------
        $submission = null;
        if ($form->store_submissions) {
            if (!empty($uploadMetadata)) {
                $submissionData['uploads'] = $uploadMetadata;
            }

            $metadata = [
                'subject'          => $allData['_subject'] ?? null,
                'replyto'          => $allData['_replyto'] ?? $allData['email'] ?? null,
                'template'         => $allData['_template'] ?? 'basic',
                'has_attachment'   => !empty($uploadedFiles),
                'attachment_count' => count($uploadedFiles),
                'attachments'      => $uploadMetadata,
            ];

            $submission = Submission::create([
                'form_id'     => $form->id,
                'data'        => $submissionData,
                'metadata'    => $metadata,
                'ip_address'  => $request->ip(),
                'user_agent'  => $request->userAgent(),
                'referrer'    => $request->header('Referer'),
                'is_spam'     => $spamCheck['is_spam'],
                'is_archived' => false,   // ← NEVER archive active-form submissions
                'spam_reason' => $spamCheck['is_spam'] ? implode(', ', $spamCheck['reasons']) : null,
            ]);

            if ($visitorEmail && $form->auto_response_enabled) {
                $submission->update(['auto_response_sent' => true]);
            }

            Log::info(
                'Submission created: ID ' . $submission->id .
                ' | spam=' . ($spamCheck['is_spam'] ? 'yes' : 'no') .
                ' | files=' . count($uploadedFiles)
            );
        }

        // -----------------------------------------------------------------
        // UPDATE FORM STATS
        // -----------------------------------------------------------------
        $form->incrementSubmissionCount($spamCheck['is_spam']);

        // -----------------------------------------------------------------
        // EMAIL NOTIFICATION (non-spam only)
        // -----------------------------------------------------------------
        if (!$spamCheck['is_spam'] && $form->email_notifications) {
            $this->sendNotificationEmail(
                $form, $allData, $submissionData, $submission, $uploadedFiles, $uploadMetadata
            );
        }

        return $this->successResponse($request, $form, $allData);
    }

    // =========================================================================
    // TOGGLE archive_when_paused SETTING (dashboard PATCH route)
    // =========================================================================

    public function toggleArchive(Request $request, Form $form)
    {
        $newValue = $request->boolean('archive_when_paused');

        $form->update(['archive_when_paused' => $newValue]);

        Log::info('Form #' . $form->id . ' archive_when_paused → ' . ($newValue ? 'ON' : 'OFF'));

        return back()->with('success', 'Archive setting updated.');
    }

    // =========================================================================
    // PRIVATE: STORE PAUSED-FORM SUBMISSION IN ARCHIVE
    // =========================================================================

    private function storeArchivedSubmission(Request $request, Form $form): void
    {
        $allData        = $request->except(['_token']);
        $internalFields = ['_gotcha', '_honeypot', '_next', '_format', '_form_load_time', '_cc'];
        $submissionData = [];

        foreach ($allData as $key => $value) {
            if (!in_array($key, $internalFields) && $key !== $form->honeypot_field) {
                if (!$request->hasFile($key)) {
                    $submissionData[$key] = $value;
                }
            }
        }

        // File uploads — skip oversized files silently instead of erroring
        $uploadedFiles  = [];
        $uploadMetadata = [];

        foreach ($request->allFiles() as $fieldName => $files) {
            if (in_array($fieldName, $internalFields)) {
                continue;
            }

            $filesArray = is_array($files) ? $files : [$files];

            foreach ($filesArray as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                $maxBytes = ($form->max_file_size ?? 10) * 1024 * 1024;
                if ($file->getSize() > $maxBytes) {
                    Log::warning('Archived sub: file skipped (too large) - ' . $file->getClientOriginalName());
                    continue;
                }

                $originalName = $file->getClientOriginalName();
                $safeName     = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
                $filename     = time() . '_' . uniqid() . '_' . $safeName;

                try {
                    $path         = $file->storeAs('uploads/' . $form->id, $filename, 'public');
                    $absolutePath = Storage::disk('public')->path($path);

                    $meta = [
                        'name'          => $originalName,
                        'filename'      => $filename,
                        'path'          => $path,
                        'absolute_path' => $absolutePath,
                        'size'          => $file->getSize(),
                        'type'          => $file->getMimeType(),
                        'extension'     => $file->getClientOriginalExtension(),
                        'field_name'    => $fieldName,
                    ];

                    $uploadedFiles[]  = $absolutePath;
                    $uploadMetadata[] = $meta;
                } catch (\Exception $e) {
                    Log::error('Archived sub file upload failed: ' . $e->getMessage());
                }
            }
        }

        if (!empty($uploadMetadata)) {
            $submissionData['uploads'] = $uploadMetadata;
        }

        $metadata = [
            'subject'          => $allData['_subject'] ?? null,
            'replyto'          => $allData['_replyto'] ?? $allData['email'] ?? null,
            'template'         => $allData['_template'] ?? 'basic',
            'has_attachment'   => !empty($uploadedFiles),
            'attachment_count' => count($uploadedFiles),
            'attachments'      => $uploadMetadata,
            'archived_reason'  => 'form_paused',
        ];

        try {
            $sub = Submission::create([
                'form_id'     => $form->id,
                'data'        => $submissionData,
                'metadata'    => $metadata,
                'ip_address'  => $request->ip(),
                'user_agent'  => $request->userAgent(),
                'referrer'    => $request->header('Referer'),
                'is_spam'     => false,   // archived ≠ spam
                'is_archived' => true,    // ← ONLY flag that sends it to archive tab
                'spam_reason' => null,
            ]);

            Log::info('Archived submission stored (form paused): ID ' . $sub->id);
        } catch (\Exception $e) {
            Log::error('Failed to store archived submission: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // PRIVATE: FILE UPLOAD HANDLER (active form submissions)
    // Returns [$uploadedFiles, $uploadMetadata, $errorOrNull]
    // =========================================================================

    private function handleFileUploads(Request $request, Form $form, array $internalFields): array
    {
        $uploadedFiles  = [];
        $uploadMetadata = [];

        Log::info('FILE UPLOAD CHECK', ['all_files' => array_keys($request->allFiles())]);

        $maxFiles   = $form->max_files ?? 5;
        $totalFiles = 0;

        foreach ($request->allFiles() as $files) {
            $totalFiles += is_array($files) ? count($files) : 1;
        }

        if ($totalFiles > $maxFiles) {
            return [[], [], "Maximum {$maxFiles} files allowed. You uploaded {$totalFiles} files."];
        }

        foreach ($request->allFiles() as $fieldName => $files) {
            if (in_array($fieldName, $internalFields)) {
                continue;
            }

            $filesArray = is_array($files) ? $files : [$files];

            foreach ($filesArray as $file) {
                if (!$file || !$file->isValid()) {
                    continue;
                }

                Log::info('File detected in field: ' . $fieldName);

                $maxBytes = ($form->max_file_size ?? 10) * 1024 * 1024;
                $fileSize = $file->getSize();

                if ($fileSize > $maxBytes) {
                    $maxMB = $maxBytes / 1024 / 1024;
                    $error = "File too large. Maximum size is {$maxMB}MB. Your file: "
                           . round($fileSize / 1024 / 1024, 2) . "MB";
                    Log::error($error);
                    return [[], [], $error];
                }

                $originalName = $file->getClientOriginalName();
                $safeName     = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
                $filename     = time() . '_' . uniqid() . '_' . $safeName;

                try {
                    $path         = $file->storeAs('uploads/' . $form->id, $filename, 'public');
                    $absolutePath = Storage::disk('public')->path($path);

                    $meta = [
                        'name'          => $originalName,
                        'filename'      => $filename,
                        'path'          => $path,
                        'absolute_path' => $absolutePath,
                        'size'          => $fileSize,
                        'type'          => $file->getMimeType(),
                        'extension'     => $file->getClientOriginalExtension(),
                        'field_name'    => $fieldName,
                    ];

                    $uploadedFiles[]  = $absolutePath;
                    $uploadMetadata[] = $meta;

                    Log::info('FILE UPLOADED', [
                        'original_name' => $meta['name'],
                        'stored_as'     => $meta['filename'],
                        'size'          => $meta['size'] . ' bytes',
                        'field'         => $fieldName,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to store file: ' . $e->getMessage());
                    return [[], [], 'Failed to upload file. Please try again.'];
                }
            }
        }

        return [$uploadedFiles, $uploadMetadata, null];
    }

    // =========================================================================
    // PRIVATE: SEND NOTIFICATION EMAIL TO FORM OWNER
    // =========================================================================

    private function sendNotificationEmail(
        Form        $form,
        array       $allData,
        array       $submissionData,
        ?Submission $submission,
        array       $uploadedFiles,
        array       $uploadMetadata
    ): void {
        try {
            $ccEmails = [];

            if (!empty($form->cc_emails)) {
                $ccEmails = is_string($form->cc_emails)
                    ? array_map('trim', explode(',', $form->cc_emails))
                    : $form->cc_emails;
            }

            if (!empty($allData['_cc'])) {
                $ccEmails = array_merge($ccEmails, array_map('trim', explode(',', $allData['_cc'])));
            }

            $ccEmails = array_values(array_unique(
                array_filter($ccEmails, fn($e) => !empty($e) && filter_var($e, FILTER_VALIDATE_EMAIL))
            ));

            Log::info('CC Emails resolved', ['final_list' => $ccEmails]);

            $mail = new FormSubmissionMail(
                $form, $submissionData, $submission, $uploadedFiles, $uploadMetadata
            );

            Log::info('Sending email ' . (count($uploadedFiles) > 0
                ? 'WITH ' . count($uploadedFiles) . ' attachment(s)'
                : 'WITHOUT attachments'));

            if (!empty($ccEmails)) {
                Mail::to($form->recipient_email)->cc($ccEmails)->send($mail);
            } else {
                Mail::to($form->recipient_email)->send($mail);
            }

            if ($submission) {
                $submission->update([
                    'email_sent'    => true,
                    'email_sent_at' => now(),
                ]);
            }

            Log::info('Email sent successfully to: ' . $form->recipient_email);
        } catch (\Exception $e) {
            Log::error('Failed to send email: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    // =========================================================================
    // PRIVATE: AUTO-RESPONSE TO VISITOR
    // =========================================================================

    private function sendAutoResponse(Form $form, array $submissionData): void
    {
        try {
            $visitorEmail = $form->getVisitorEmail($submissionData);

            if (!$visitorEmail) {
                Log::warning('Auto-response: No email field found');
                return;
            }

            $defaultMessage =
                "Dear {visitor_name},\n\n" .
                "Thank you for contacting us! We have received your submission and will get back to you shortly.\n\n" .
                "Best regards,\n" . config('app.name');

            $messageContent = $form->auto_response_message ?? $defaultMessage;
            $messageContent = $form->parseAutoResponseMessage($messageContent, $submissionData);

            $mail = new \App\Mail\AutoResponseMail($form, $submissionData, $messageContent);
            Mail::to($visitorEmail)->send($mail);

            Log::info('Auto-response sent to: ' . $visitorEmail);
        } catch (\Exception $e) {
            Log::error('Auto-response failed: ' . $e->getMessage());
        }
    }

    // =========================================================================
    // RESPONSES
    // =========================================================================

    /**
     * Returned to visitors when the form is paused.
     * Always an error — NEVER shows success.
     */
    private function pausedResponse(Request $request)
    {
        $message = 'The owner of this form has disabled this form and it is no longer accepting submissions';

        if ($request->wantsJson() || $request->input('_format') === 'json') {
            return response()->json(['success' => false, 'error' => $message], 403);
        }

        return response()->view('pages.form-not-active', ['message' => $message], 403);
    }

    protected function successResponse(Request $request, Form $form, array $data)
    {
        if ($request->wantsJson() || $request->input('_format') === 'json') {
            return response()->json(['success' => true, 'message' => $form->success_message]);
        }

        $redirectUrl = $data['_next'] ?? $form->redirect_url;

        if ($redirectUrl) {
            return redirect()->away($redirectUrl);
        }

        return view('pages.thank-you', [
            'message' => $form->success_message,
            'referer' => $request->header('Referer'),
        ]);
    }

    protected function errorResponse(Request $request, string $message, int $status = 422)
    {
        if ($request->wantsJson() || $request->input('_format') === 'json') {
            return response()->json(['success' => false, 'error' => $message], $status);
        }

        return back()->with('error', $message)->withInput();
    }

    // =========================================================================
    // FILE DOWNLOAD
    // =========================================================================

    public function downloadFile(Request $request, $formId, $submissionId)
    {
        $submission = Submission::where('form_id', $formId)->findOrFail($submissionId);

        $fileIndex = $request->input('file_index', 0);
        $uploads   = $submission->data['uploads'] ?? null;

        if (!$uploads || !is_array($uploads) || !isset($uploads[$fileIndex])) {
            abort(404, 'File not found');
        }

        $fileData = $uploads[$fileIndex];

        if (!isset($fileData['absolute_path'])) {
            abort(404, 'File path not found');
        }

        $filePath = $fileData['absolute_path'];

        if (!file_exists($filePath)) {
            abort(404, 'File does not exist on server');
        }

        if ($request->has('preview')) {
            return response()->file($filePath, [
                'Content-Type' => $fileData['type'] ?? 'application/octet-stream',
            ]);
        }

        return response()->download(
            $filePath,
            $fileData['name'] ?? 'file',
            ['Content-Type' => $fileData['type'] ?? 'application/octet-stream']
        );
    }
}