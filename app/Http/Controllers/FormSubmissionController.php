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
        
        // SIMPLE FIX: Only exclude honeypot and gotcha from submission data
        // Keep _subject, _replyto, and _template in the data so email can use them
        $internalFields = ['_gotcha', '_honeypot', '_next', '_format', '_form_load_time'];
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

        // FILE UPLOAD HANDLING - Store file and metadata
        $uploadedFilePath = null;
        $uploadMetadata = null;
        
        Log::info('FILE UPLOAD CHECK', [
            'form_allows_upload' => $form->allow_file_upload ?? false,
            'has_upload_file' => $request->hasFile('upload'),
            'all_files' => array_keys($request->allFiles()),
        ]);
        
        // Check for file upload - look for ANY file field, not just 'upload'
        $uploadedFile = null;
        $uploadFieldName = null;
        
        // First, try the standard 'upload' field
        if ($request->hasFile('upload')) {
            $uploadedFile = $request->file('upload');
            $uploadFieldName = 'upload';
        } else {
            // Check for any other file fields
            foreach ($request->allFiles() as $fieldName => $file) {
                if (!in_array($fieldName, $internalFields)) {
                    $uploadedFile = $file;
                    $uploadFieldName = $fieldName;
                    break;
                }
            }
        }
        
        if ($uploadedFile && $uploadedFile->isValid()) {
            Log::info('File detected in field: ' . $uploadFieldName);
            
            // ============ FILE SIZE VALIDATION (Like FormSubmit.co) ============
            // Default max file size: 10MB (Free tier) - can be configurable per form
            $maxFileSize = ($form->max_file_size ?? 10) * 1024 * 1024; // Convert MB to bytes
            $fileSize = $uploadedFile->getSize();
            $fileName = $uploadedFile->getClientOriginalName();
            
            // Check file size only - no MIME/type restrictions (like FormSubmit.co)
            if ($fileSize > $maxFileSize) {
                $maxSizeMB = $maxFileSize / 1024 / 1024;
                $error = "File too large. Maximum size is {$maxSizeMB}MB. Your file: " . round($fileSize / 1024 / 1024, 2) . "MB";
                Log::error($error);
                
                return $this->errorResponse($request, $error, 422);
            }
            
            // Generate unique filename - sanitize to prevent path traversal
            $originalName = $uploadedFile->getClientOriginalName();
            $safeName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
            $filename = time() . '_' . $safeName;
            
            // Store the file
            try {
                $path = $uploadedFile->storeAs('uploads/' . $form->id, $filename, 'public');
                
                // Get absolute path
                $absolutePath = Storage::disk('public')->path($path);
                
                // Store metadata
                $uploadMetadata = [
                    'name' => $originalName,
                    'filename' => $filename,
                    'path' => $path,
                    'absolute_path' => $absolutePath,
                    'size' => $fileSize,
                    'type' => $uploadedFile->getMimeType(), // Just for reference, not used for validation
                    'extension' => $uploadedFile->getClientOriginalExtension(),
                ];
                
                // Store the absolute path for email attachment
                $uploadedFilePath = $absolutePath;
                
                // Store metadata in submission data
                $submissionData['upload'] = $uploadMetadata;
                
                Log::info('FILE UPLOADED SUCCESSFULLY', [
                    'original_name' => $uploadMetadata['name'],
                    'stored_as' => $uploadMetadata['filename'],
                    'size' => $uploadMetadata['size'] . ' bytes',
                ]);
                
            } catch (\Exception $e) {
                Log::error('Failed to store file: ' . $e->getMessage());
                return $this->errorResponse($request, 'Failed to upload file. Please try again.', 500);
            }
            
        } else {
            Log::info('No valid file uploaded');
        }

        // Check for spam
        $spamCheck = $this->spamDetector->isSpam($form, $request, $allData);

        // Create submission record
        $submission = null;
        if ($form->store_submissions) {
            $metadata = [
                'subject' => $allData['_subject'] ?? null,
                'replyto' => $allData['_replyto'] ?? $allData['email'] ?? null,
                'template' => $allData['_template'] ?? 'basic',
                'has_attachment' => $uploadedFilePath !== null,
                'attachment_name' => $uploadMetadata['name'] ?? null,
                'attachment_size' => $uploadMetadata['size'] ?? null,
            ];
            
            $submission = Submission::create([
                'form_id' => $form->id,
                'data' => $submissionData,
                'metadata' => $metadata,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referrer' => $request->header('Referer'),
                'is_spam' => $spamCheck['is_spam'],
                'spam_reason' => $spamCheck['is_spam'] ? implode(', ', $spamCheck['reasons']) : null,
            ]);
            
            Log::info('Submission created: ID ' . $submission->id);
        }

        // Update form stats
        $form->incrementSubmissionCount($spamCheck['is_spam']);

        // Send email notification if not spam
        if (!$spamCheck['is_spam'] && $form->email_notifications) {
            try {
                Log::info('Preparing to send email', [
                    'to' => $form->recipient_email,
                    'has_attachment' => $uploadedFilePath !== null,
                    'attachment_name' => $uploadMetadata['name'] ?? null,
                    'has_subject' => isset($submissionData['_subject']),
                    'subject_value' => $submissionData['_subject'] ?? 'not set',
                    'template' => $submissionData['_template'] ?? 'basic',
                ]);
                
                // Pass the absolute file path directly to the mail class
                $mail = new FormSubmissionMail(
                    $form, 
                    $submissionData, // This includes _subject, _replyto, and _template now
                    $submission,
                    $uploadedFilePath,  // Pass the actual file path
                    $uploadMetadata     // Pass metadata for display
                );
                
                $ccEmails = [];
                if (!empty($form->cc_emails)) {
                    if (is_string($form->cc_emails)) {
                        $ccEmails = array_map('trim', explode(',', $form->cc_emails));
                    } elseif (is_array($form->cc_emails)) {
                        $ccEmails = $form->cc_emails;
                    }
                    
                    $ccEmails = array_values(array_filter($ccEmails, function($email) {
                        return !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);
                    }));
                }
                
                Log::info('Sending email ' . ($uploadedFilePath ? 'WITH' : 'WITHOUT') . ' attachment');
                
                if (!empty($ccEmails)) {
                    Mail::to($form->recipient_email)->cc($ccEmails)->send($mail);
                } else {
                    Mail::to($form->recipient_email)->send($mail);
                }

                if ($submission) {
                    $submission->update([
                        'email_sent' => true,
                        'email_sent_at' => now(),
                    ]);
                }
                
                Log::info('Email sent successfully to: ' . $form->recipient_email);
                
            } catch (\Exception $e) {
                Log::error('Failed to send email: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
            }
        }

        // Send auto-response if enabled and not spam
        if (!$spamCheck['is_spam'] && $form->auto_response_enabled) {
            $this->sendAutoResponse($form, $submissionData);
        }

        // Return response
        return $this->successResponse($request, $form, $allData);
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
            
            Log::info('✅ Auto-response sent to: ' . $visitorEmail);
            
        } catch (\Exception $e) {
            Log::error('❌ Auto-response failed: ' . $e->getMessage());
        }
    }

    /**
     * Download a file from a submission
     */
    public function downloadFile(Request $request, $formId, $submissionId)
    {
        $submission = Submission::where('form_id', $formId)->findOrFail($submissionId);
        $fieldName = $request->input('field_name', 'upload');
        
        // Get the file metadata from submission data
        $fileData = $submission->data[$fieldName] ?? null;
        
        if (!$fileData || !is_array($fileData) || !isset($fileData['absolute_path'])) {
            abort(404, 'File not found');
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