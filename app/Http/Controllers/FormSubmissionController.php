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

    public function submit(Request $request, string $slug)
    {
        // Find the form
        $form = Form::where('slug', $slug)->first();

        if (!$form) {
            return $this->errorResponse($request, 'Form not found', 404);
        }

        // Check if form can accept submissions
        if (!$form->canAcceptSubmissions()) {
            if (!$form->email_verified) {
                return $this->errorResponse($request, 'Form email not verified', 403);
            }
            return $this->errorResponse($request, 'Form is not accepting submissions', 403);
        }

        // Check domain restrictions
        if (!$form->isDomainAllowed($request->header('Referer'))) {
            return $this->errorResponse($request, 'Submissions from this domain are not allowed', 403);
        }

        // Get form data
        $allData = $request->except(['_token']);
        
        // Only exclude honeypot and gotcha from submission data
        // Keep _subject, _replyto, and _template in the data so email can use them
        $internalFields = ['_gotcha', '_honeypot', '_next', '_format', '_form_load_time', '_cc'];
        $submissionData = [];
        
        // Process regular fields - EXCLUDE file uploads
        foreach ($allData as $key => $value) {
            if (!in_array($key, $internalFields) && $key !== $form->honeypot_field) {
                // Skip ALL file inputs - they'll be handled separately
                if (!$request->hasFile($key)) {
                    $submissionData[$key] = $value;
                }
            }
        }

        // ============ MULTIPLE FILE UPLOAD HANDLING ============
        $uploadedFiles = [];
        $uploadMetadata = [];
        
        Log::info('FILE UPLOAD CHECK', [
            'form_allows_upload' => $form->allow_file_upload ?? false,
            'all_files' => array_keys($request->allFiles()),
        ]);
        
        // Limit total number of files
        $maxFiles = $form->max_files ?? 5;
        $totalFiles = 0;
        
        foreach ($request->allFiles() as $files) {
            $totalFiles += is_array($files) ? count($files) : 1;
        }
        
        if ($totalFiles > $maxFiles) {
            return $this->errorResponse($request, "Maximum {$maxFiles} files allowed. You uploaded {$totalFiles} files.", 422);
        }
        
        // Check for file uploads in any field
        foreach ($request->allFiles() as $fieldName => $files) {
            // Skip internal fields
            if (in_array($fieldName, $internalFields)) {
                continue;
            }
            
            // Handle both single file and multiple files (files[])
            $filesArray = is_array($files) ? $files : [$files];
            
            foreach ($filesArray as $uploadedFile) {
                if (!$uploadedFile || !$uploadedFile->isValid()) {
                    continue;
                }
                
                Log::info('File detected in field: ' . $fieldName);
                
                // FILE SIZE VALIDATION
                $maxFileSize = ($form->max_file_size ?? 10) * 1024 * 1024; // Convert MB to bytes
                $fileSize = $uploadedFile->getSize();
                
                if ($fileSize > $maxFileSize) {
                    $maxSizeMB = $maxFileSize / 1024 / 1024;
                    $error = "File too large. Maximum size is {$maxSizeMB}MB. Your file: " . round($fileSize / 1024 / 1024, 2) . "MB";
                    Log::error($error);
                    return $this->errorResponse($request, $error, 422);
                }
                
                // Generate unique filename - sanitize to prevent path traversal
                $originalName = $uploadedFile->getClientOriginalName();
                $safeName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
                $filename = time() . '_' . uniqid() . '_' . $safeName;
                
                // Store the file
                try {
                    $path = $uploadedFile->storeAs('uploads/' . $form->id, $filename, 'public');
                    $absolutePath = Storage::disk('public')->path($path);
                    
                    $metadata = [
                        'name' => $originalName,
                        'filename' => $filename,
                        'path' => $path,
                        'absolute_path' => $absolutePath,
                        'size' => $fileSize,
                        'type' => $uploadedFile->getMimeType(),
                        'extension' => $uploadedFile->getClientOriginalExtension(),
                        'field_name' => $fieldName,
                    ];
                    
                    $uploadedFiles[] = $absolutePath;
                    $uploadMetadata[] = $metadata;
                    
                    Log::info('FILE UPLOADED SUCCESSFULLY', [
                        'original_name' => $metadata['name'],
                        'stored_as' => $metadata['filename'],
                        'size' => $metadata['size'] . ' bytes',
                        'field' => $fieldName,
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Failed to store file: ' . $e->getMessage());
                    return $this->errorResponse($request, 'Failed to upload file. Please try again.', 500);
                }
            }
        }
        
        Log::info('Total files uploaded: ' . count($uploadedFiles));

        // Send auto-response BEFORE spam check
        // This ensures users always get confirmation even if marked as spam
        $visitorEmail = null;
        if ($form->auto_response_enabled) {
            $visitorEmail = $form->getVisitorEmail($submissionData);
            if ($visitorEmail) {
                $this->sendAutoResponse($form, $submissionData);
            } else {
                Log::warning('Auto-response: No email field found in submission');
            }
        }

        // Check for spam
        $spamCheck = $this->spamDetector->isSpam($form, $request, $allData);

        // Create submission record
        $submission = null;
        if ($form->store_submissions) {
            // Store file metadata in submission data
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
                'spam_reason' => $spamCheck['is_spam'] ? implode(', ', $spamCheck['reasons']) : null,
            ]);
            
            // Track if auto-response was sent
            if ($visitorEmail && $form->auto_response_enabled) {
                $submission->update(['auto_response_sent' => true]);
            }
            
            Log::info('Submission created: ID ' . $submission->id . ' with ' . count($uploadedFiles) . ' file(s)');
        }

        // Update form stats
        $form->incrementSubmissionCount($spamCheck['is_spam']);

        // Send email notification ONLY if not spam
        if (!$spamCheck['is_spam'] && $form->email_notifications) {
            try {
                // ============ RESOLVE CC EMAILS ============
                $ccEmails = [];

                // 1. CC from dashboard form settings
                if (!empty($form->cc_emails)) {
                    if (is_string($form->cc_emails)) {
                        $ccEmails = array_map('trim', explode(',', $form->cc_emails));
                    } elseif (is_array($form->cc_emails)) {
                        $ccEmails = $form->cc_emails;
                    }
                }

                // 2. CC from hidden _cc input field (single or comma-separated)
                if (!empty($allData['_cc'])) {
                    $fieldCcEmails = array_map('trim', explode(',', $allData['_cc']));
                    $ccEmails = array_merge($ccEmails, $fieldCcEmails);
                }

                // 3. Validate all emails and remove duplicates
                $ccEmails = array_values(array_unique(
                    array_filter($ccEmails, function ($email) {
                        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
                    })
                ));

                Log::info('CC Emails resolved', [
                    'from_dashboard' => $form->cc_emails ?? [],
                    'from_field'     => $allData['_cc'] ?? 'none',
                    'final_list'     => $ccEmails,
                ]);

                // ==========================================

                Log::info('Preparing to send email', [
                    'to'               => $form->recipient_email,
                    'cc_count'         => count($ccEmails),
                    'has_attachments'  => !empty($uploadedFiles),
                    'attachment_count' => count($uploadedFiles),
                    'subject_value'    => $submissionData['_subject'] ?? 'not set',
                    'template'         => $submissionData['_template'] ?? 'basic',
                ]);
                
                // Pass arrays of file paths and metadata
                $mail = new \App\Mail\FormSubmissionMail(
                    $form, 
                    $submissionData,
                    $submission,
                    $uploadedFiles,
                    $uploadMetadata
                );

                $attachmentText = count($uploadedFiles) > 0
                    ? 'WITH ' . count($uploadedFiles) . ' attachment(s)'
                    : 'WITHOUT attachments';
                Log::info('Sending email ' . $attachmentText);
                
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

        // (it's now handled BEFORE spam check)

        // Return response
        return $this->successResponse($request, $form, $allData);
    }

    /**
     * Enhanced auto-response method with better tracking
     */
    protected function sendAutoResponse(Form $form, array $submissionData): void
    {
        try {
            // Get visitor's email
            $visitorEmail = $form->getVisitorEmail($submissionData);
            
            if (!$visitorEmail) {
                Log::warning('Auto-response: No email field found');
                return;
            }

            // Default message
            $defaultMessage = "Dear {visitor_name},\n\nThank you for contacting us! We have received your submission and will get back to you shortly.\n\nBest regards,\n" . config('app.name');
            
            // Get message
            $messageContent = $form->auto_response_message ?? $defaultMessage;
            
            // Parse placeholders
            $messageContent = $form->parseAutoResponseMessage($messageContent, $submissionData);
            
            // Send email
            $mail = new \App\Mail\AutoResponseMail($form, $submissionData, $messageContent);
            Mail::to($visitorEmail)->send($mail);
            
            Log::info('Auto-response sent to: ' . $visitorEmail);
            
        } catch (\Exception $e) {
            Log::error('Auto-response failed: ' . $e->getMessage());
        }
    }

    protected function successResponse(Request $request, Form $form, array $data)
    {
        if ($request->wantsJson() || $request->input('_format') === 'json') {
            return response()->json([
                'success' => true,
                'message' => $form->success_message,
            ]);
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
            return response()->json([
                'success' => false,
                'error' => $message,
            ], $status);
        }

        return back()->with('error', $message)->withInput();
    }

    /**
     * Download a file from a submission
     */
    public function downloadFile(Request $request, $formId, $submissionId)
    {
        $submission = Submission::where('form_id', $formId)->findOrFail($submissionId);
        
        // Get file index (for multiple files)
        $fileIndex = $request->input('file_index', 0);
        
        // Get the file metadata from submission data
        $uploads = $submission->data['uploads'] ?? null;
        
        if (!$uploads || !is_array($uploads) || !isset($uploads[$fileIndex])) {
            abort(404, 'File not found');
        }
        
        $fileData = $uploads[$fileIndex];
        
        if (!isset($fileData['absolute_path'])) {
            abort(404, 'File path not found');
        }
        
        $filePath = $fileData['absolute_path'];
        
        // Check if file exists
        if (!file_exists($filePath)) {
            abort(404, 'File does not exist on server');
        }
        
        // If it's a preview request, return the file inline
        if ($request->has('preview')) {
            return response()->file($filePath, [
                'Content-Type' => $fileData['type'] ?? 'application/octet-stream',
            ]);
        }
        
        // Return as download
        return response()->download(
            $filePath, 
            $fileData['name'] ?? 'file',
            [
                'Content-Type' => $fileData['type'] ?? 'application/octet-stream',
            ]
        );
    }
}