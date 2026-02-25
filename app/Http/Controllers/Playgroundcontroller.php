<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\UploadedFile;
use App\Mail\PlaygroundFormSubmissionMail;
use App\Mail\PlaygroundVerificationMail;
use App\Models\Form;
use App\Models\Submission;

class PlaygroundController extends Controller
{
    /**
     * Show the playground page
     */
    public function index()
    {
        return view('pages.playground');
    }

    /**
     * Show form submitted thank you page
     */
    public function formSubmitted()
    {
        return view('pages.form-submitted');
    }

    /**
     * Show form endpoint info page
     */
    public function formEndpointInfo(string $email)
    {
        $email    = strtolower(trim($email));
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);
        $verified = $data && !empty($data['verified']);

        return view('pages.form-endpoint-info', compact('email', 'verified'));
    }

    /**
     * Send verification email
     */
    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid email address.'], 422);
        }

        $email    = strtolower(trim($request->email));
        $limitKey = 'playground_verify_limit_' . md5($email);
        $attempts = Cache::get($limitKey, 0);

        if ($attempts >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Too many attempts. Please wait 10 minutes.',
            ], 429);
        }

        Cache::put($limitKey, $attempts + 1, now()->addMinutes(10));
        $this->sendVerification($email);

        return response()->json(['success' => true, 'message' => 'Verification email sent.']);
    }

    /**
     * Confirm email verification
     */
    public function confirmEmail(Request $request)
    {
        $email    = strtolower(trim($request->query('email', '')));
        $token    = $request->query('token', '');
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        if (!$data || ($data['token'] ?? '') !== $token) {
            return view('pages.playground-verify-result', [
                'success' => false,
                'message' => 'This verification link is invalid or has expired.',
                'email'   => $email,
            ]);
        }

        Cache::forever($cacheKey, array_merge($data, ['verified' => true]));
        Log::info('Playground: email verified', ['email' => $email]);

        return view('pages.playground-verify-result', [
            'success' => true,
            'message' => 'Your email has been verified! You can now close this tab and submit the form.',
            'email'   => $email,
        ]);
    }

    /**
     * Check if email is verified
     */
    public function checkVerified(Request $request)
    {
        $email    = strtolower(trim($request->query('email', '')));
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        return response()->json([
            'verified' => $data && !empty($data['verified']),
        ]);
    }

    /**
     * SHOW CAPTCHA PAGE - Using dedicated playground captcha view
     */
    public function showCaptcha($email)
    {
        Log::info('Playground: Showing captcha page', ['email' => $email]);
        
        $email = strtolower(trim($email));
        
        // Check if there's a pending submission
        if (!Session::has('pending_playground_' . md5($email))) {
            Log::warning('Playground: No pending submission found', ['email' => $email]);
            return redirect()->route('playground.index')->with('error', 'No pending submission found.');
        }
        
        // Use the dedicated playground captcha view
        return view('pages.playground-captcha', [
            'siteKey' => config('services.recaptcha.site_key'),
            'email' => $email
        ]);
    }

    /**
     * VERIFY CAPTCHA AND PROCESS
     */
    public function verifyCaptcha(Request $request, $email)
    {
        Log::info('Playground: Captcha verification started', ['email' => $email]);
        
        $email = strtolower(trim($email));
        $token = $request->input('g-recaptcha-response');
        
        // Get client IP with fallback
        $clientIp = $request->ip() ?? $request->getClientIp() ?? '0.0.0.0';
        
        Log::info('Playground: Verifying captcha', ['token_exists' => !empty($token), 'ip' => $clientIp]);
        
        // Verify captcha
        $recaptcha = app(\App\Services\RecaptchaService::class);
        
        if ($recaptcha->verify($token, $clientIp)) {
            Log::info('Playground: Captcha verified successfully');
            
            // Get pending submission
            $pendingKey = 'pending_playground_' . md5($email);
            $pending = Session::get($pendingKey);
            
            if ($pending) {
                Log::info('Playground: Pending submission found', [
                    'data_keys' => array_keys($pending['data'] ?? []),
                    'stored_ip' => $pending['ip'] ?? 'not stored',
                    'source' => $pending['source'] ?? 'playground'
                ]);
                
                // Determine if this came from playground or external
                $source = $pending['source'] ?? 'playground';
                
                // Store the pending data
                $storedData = $pending['data'];
                $storedFiles = $pending['files'] ?? [];
                $storedIp = $pending['ip'] ?? $clientIp;
                $storedUserAgent = $pending['user_agent'] ?? $request->userAgent();
                $storedReferrer = $pending['referrer'] ?? $request->header('Referer');
                
                // Add captcha verified flag (internal only)
                $storedData['captcha_verified'] = true;
                $storedData['recipient_email'] = $email;
                
                // Remove any existing token
                unset($storedData['g-recaptcha-response']);
                
                // Recreate the request with files
                $newRequest = $this->recreateRequestWithFiles(
                    $storedData, 
                    $storedFiles, 
                    $email,
                    $storedIp,
                    $storedUserAgent,
                    $storedReferrer
                );
                
                Log::info('Playground: Recreated request', [
                    'has_files' => count($newRequest->allFiles()),
                    'ip' => $storedIp,
                    'source' => $source
                ]);
                
                // Clean up session
                Session::forget($pendingKey);
                
                // Process the submission (skipping captcha)
                $response = $this->processVerifiedSubmission($newRequest, $email);
                
                // Check if this is a JSON response (AJAX request)
                if ($response instanceof \Illuminate\Http\JsonResponse) {
                    return $response;
                }
                
                // If it came from playground (source is 'playground'), redirect back to playground
                if ($source === 'playground') {
                    Log::info('Playground: Redirecting back to playground after verification');
                    return redirect()->route('playground.index')->with('success', 'Form submitted successfully! Check your email.');
                }
                
                // Otherwise, it came from external form, redirect to appropriate response page
                Log::info('Playground: Redirecting to form submitted page');
                return $response;
                
            } else {
                Log::warning('Playground: No pending submission found after captcha verification');
            }
        } else {
            Log::warning('Playground: Captcha verification failed');
        }
        
        // If verification failed, redirect back to captcha with error
        return redirect()->route('playground.show-captcha', ['email' => $email])
            ->with('error', 'Captcha verification failed. Please try again.');
    }

    /**
     * Handle form submission (main entry point)
     */
    public function submit(Request $request)
    {
        Log::info('Playground submit called', [
            'has_recipient_email' => $request->has('recipient_email'),
            'has_form_slug'       => $request->has('form_slug'),
            'method'              => $request->method(),
            'url'                 => $request->fullUrl(),
        ]);

        $isPlaygroundSubmission = $request->has('recipient_email') && !$request->has('form_slug');

        if ($isPlaygroundSubmission) {
            return $this->handlePlaygroundSubmission($request);
        } else {
            return $this->handleExternalFormSubmission($request);
        }
    }

    /**
     * Handle playground-specific submissions with captcha flow
     */
    protected function handlePlaygroundSubmission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => '⚠️ Missing recipient email. Please refresh and try again.',
            ], 422);
        }

        $recipientEmail = strtolower(trim($request->recipient_email));
        $cacheKey       = 'playground_verify_' . md5($recipientEmail);
        $data           = Cache::get($cacheKey);

        // Check if email is verified
        if (!$data || empty($data['verified'])) {
            Log::warning('Playground: submit without verification', ['email' => $recipientEmail]);
            return response()->json([
                'success' => false,
                'message' => '⚠️ Please verify your email first.',
            ], 403);
        }

        // Check if this is a return from captcha verification
        $isCaptchaVerified = $request->has('captcha_verified') || !empty($request->input('captcha_verified'));
        
        Log::info('Playground: Captcha verification status', [
            'is_captcha_verified' => $isCaptchaVerified,
            'has_captcha_flag' => $request->has('captcha_verified')
        ]);

        // Get client IP
        $clientIp = $request->ip() ?? $request->getClientIp() ?? '0.0.0.0';

        // Check if captcha is disabled by user
        $allData = $request->except(['_token']);
        $recaptcha = app(\App\Services\RecaptchaService::class);
        $captchaDisabled = $recaptcha->isDisabledByUser($allData);

        // If this is the first submission (no captcha token and not disabled and not returning from captcha)
        if (!$isCaptchaVerified && !$captchaDisabled) {
            Log::info('Playground: Redirecting to captcha page', ['email' => $recipientEmail]);
            
            // Store the submission data in session with source = 'playground'
            Session::put('pending_playground_' . md5($recipientEmail), [
                'data' => $request->except(['_token', 'recipient_email']),
                'files' => $this->storeTempFiles($request),
                'ip' => $clientIp,
                'user_agent' => $request->userAgent(),
                'referrer' => $request->header('Referer'),
                'timestamp' => now()->toDateTimeString(),
                'source' => 'playground' // Add source identifier
            ]);
            
            // Return redirect for AJAX or normal requests
            if ($request->wantsJson() || $request->input('_format') === 'json') {
                return response()->json(['redirect' => route('playground.show-captcha', ['email' => $recipientEmail])]);
            }
            
            return redirect()->route('playground.show-captcha', ['email' => $recipientEmail]);
        }

        // If captcha is disabled, process immediately
        if ($captchaDisabled) {
            Log::info('Playground: Captcha disabled by user, processing directly');
            return $this->processVerifiedSubmission($request, $recipientEmail);
        }

        // If we have captcha_verified flag, process the submission
        if ($isCaptchaVerified) {
            Log::info('Playground: Captcha verified, processing submission');
            return $this->processVerifiedSubmission($request, $recipientEmail);
        }

        // If we reach here, something went wrong
        Log::warning('Playground: Unexpected state in submission flow');
        return response()->json([
            'success' => false,
            'message' => 'Invalid submission state. Please try again.',
        ], 400);
    }

    /**
     * Handle email endpoint submissions (from external forms via /f/email)
     */
    public function handleEmailSubmission(Request $request, string $email)
    {
        $email = strtolower(trim($email));

        Log::info('Playground email submission received', [
            'email'     => $email,
            'ip'        => $request->ip(),
            'method'    => $request->method(),
            'has_files' => count($request->allFiles()) > 0 ? 'yes' : 'no',
        ]);

        // Check if email is verified
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        if (!$data || empty($data['verified'])) {
            Log::warning('Playground: submission to unverified email', ['email' => $email]);

            if ($request->wantsJson() || $request->input('_format') === 'json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not verified. Please verify your email first.',
                ], 403);
            }

            return redirect()->route('playground.endpoint.info', ['email' => $email])
                ->with('error', 'Please verify your email first.');
        }

        // For email endpoint, we also need captcha flow
        $isCaptchaVerified = $request->has('captcha_verified') || !empty($request->input('captcha_verified'));
        $clientIp = $request->ip() ?? $request->getClientIp() ?? '0.0.0.0';
        
        $allData = $request->except(['_token']);
        $recaptcha = app(\App\Services\RecaptchaService::class);
        $captchaDisabled = $recaptcha->isDisabledByUser($allData);

        if (!$isCaptchaVerified && !$captchaDisabled) {
            Log::info('Playground email: Redirecting to captcha page', ['email' => $email]);
            
            // Store the submission data in session with source = 'external'
            Session::put('pending_playground_' . md5($email), [
                'data' => $request->except(['_token']),
                'files' => $this->storeTempFiles($request),
                'ip' => $clientIp,
                'user_agent' => $request->userAgent(),
                'referrer' => $request->header('Referer'),
                'timestamp' => now()->toDateTimeString(),
                'source' => 'external' // Add source identifier
            ]);
            
            if ($request->wantsJson() || $request->input('_format') === 'json') {
                return response()->json(['redirect' => route('playground.show-captcha', ['email' => $email])]);
            }
            
            return redirect()->route('playground.show-captcha', ['email' => $email]);
        }

        // Process the submission
        return $this->processVerifiedSubmission($request, $email);
    }

    /**
     * Handle external form submissions (from created forms)
     */
    protected function handleExternalFormSubmission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'form_slug' => 'required|string|exists:forms,slug',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid form submission.',
            ], 422);
        }

        $form = Form::where('slug', $request->form_slug)->first();

        if (!$form) {
            return response()->json(['success' => false, 'message' => 'Form not found.'], 404);
        }

        if (!$form->canAcceptSubmissions()) {
            if (!$form->email_verified) {
                return response()->json(['success' => false, 'message' => 'Form email not verified.'], 403);
            }
            return response()->json(['success' => false, 'message' => 'Form is not accepting submissions.'], 403);
        }

        if (!$form->isDomainAllowed($request->header('Referer'))) {
            return response()->json(['success' => false, 'message' => 'Submissions from this domain are not allowed.'], 403);
        }

        // For external forms, the captcha is handled by FormSubmissionController
        // This should never be called directly for captcha-protected forms
        return response()->json(['success' => false, 'message' => 'Use the main form endpoint for submissions.'], 400);
    }

    /**
     * Process a verified submission (after captcha or with captcha disabled)
     */
    protected function processVerifiedSubmission(Request $request, string $recipientEmail)
    {
        try {
            $allData = $request->except(['_token']);
            
            Log::info('Playground: Processing verified submission', [
                'recipient' => $recipientEmail,
                'all_input' => $request->except(['_token']),
                'all_files' => array_keys($request->allFiles()),
            ]);

            $specialFieldKeys = [
                '_subject', '_replyto', '_next', '_cc', '_bcc',
                '_template', '_format', '_blacklist', '_auto-response',
                '_auto-reponse',
            ];

            $submissionData = [];
            $specialData    = [];

            foreach ($allData as $key => $value) {
                if (in_array($key, $specialFieldKeys)) {
                    $normalizedKey               = ($key === '_auto-reponse') ? '_auto-response' : $key;
                    $specialData[$normalizedKey] = $value;
                    Log::info('Playground: Special field found', ['key' => $normalizedKey, 'value' => $value]);
                } elseif (!$request->hasFile($key)) {
                    $submissionData[$key] = $value;
                }
            }

            // Blacklist check
            if (!empty($specialData['_blacklist'])) {
                if ($this->handleBlacklist($specialData['_blacklist'], $request, $submissionData)) {
                    $senderEmail = $request->input('email') ?? $request->input('sender_email') ?? '';
                    if (!empty($specialData['_auto-response']) && !empty($senderEmail)) {
                        $blockedFormData = [
                            'name'         => $request->input('name') ?? 'Visitor',
                            'sender_email' => $senderEmail,
                            'form_name'    => 'Playground Form',
                        ];
                        $this->sendAutoResponse($senderEmail, $blockedFormData, $specialData);
                    }
                    return $this->handleResponse($request, $specialData, $recipientEmail);
                }
            }

            [$uploadedFiles, $uploadMetadata, $attachments, $fileError] = $this->processFileUploads(
                $request,
                'playground/temp/' . date('Y/m/d')
            );

            if ($fileError) {
                Log::warning('Playground: File upload error', ['error' => $fileError]);
                if ($request->wantsJson() || $request->input('_format') === 'json') {
                    return response()->json(['success' => false, 'message' => $fileError], 422);
                }
                return redirect()->back()->with('error', $fileError)->withInput();
            }

            $formData = $this->buildFormData($request, $recipientEmail, 'Playground Form', $submissionData, $specialData, $uploadMetadata);

            Log::info('Playground: Form data prepared', [
                'name' => $formData['name'],
                'has_sender_email' => !empty($formData['sender_email']),
                'attachments_count' => count($attachments),
            ]);

            // Send email
            try {
                Log::info('Playground: Attempting to send email', ['to' => $recipientEmail]);
                $mail = new \App\Mail\PlaygroundFormSubmissionMail($formData, $attachments, $specialData);
                Mail::to($recipientEmail)->send($mail);
                Log::info('Playground: Email sent successfully', ['to' => $recipientEmail]);
            } catch (\Exception $e) {
                Log::error('Playground: Email sending failed: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                throw $e;
            }

            // Send auto-response if enabled
            if (!empty($specialData['_auto-response']) && !empty($formData['sender_email'])) {
                try {
                    $this->sendAutoResponse($formData['sender_email'], $formData, $specialData);
                    Log::info('Playground: Auto-response sent', ['to' => $formData['sender_email']]);
                } catch (\Exception $e) {
                    Log::error('Playground: Auto-response failed: ' . $e->getMessage());
                }
            }

            // Clean up temp files
            $this->cleanupFiles($uploadedFiles);
            
            // Clean up pending submission if exists
            $pendingKey = 'pending_playground_' . md5($recipientEmail);
            if (Session::has($pendingKey)) {
                $pending = Session::get($pendingKey);
                if (!empty($pending['files'])) {
                    $this->cleanupTempFiles($pending['files']);
                }
                Session::forget($pendingKey);
            }

            Log::info('Playground: Submission completed successfully', [
                'recipient' => $recipientEmail,
                'attachments' => count($attachments),
            ]);

            // Prepare clean response data (no internal flags)
            $cleanResponse = [
                'success' => true,
                'message' => '✅ Message sent successfully!',
            ];

            // Add redirect if present in special data (but only return it, not store it)
            if (!empty($specialData['_next'])) {
                $cleanResponse['redirect'] = $specialData['_next'];
            }

            // Return response based on format - NEVER include internal flags
            if ($request->wantsJson()) {
                return response()->json($cleanResponse);
            }

            // Check if there's a custom redirect in the form data
            if (!empty($specialData['_next'])) {
                return redirect()->away($specialData['_next']);
            }

            // If no custom redirect, return to form submitted page
            return redirect()->route('playground.form.submitted')
                ->with('success', 'Form submitted successfully! Check your email.');

        } catch (\Exception $e) {
            Log::error('Playground: Submission failed — ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'file'            => $e->getFile(),
                'line'            => $e->getLine(),
                'recipient'       => $recipientEmail ?? 'unknown',
            ]);

            $errorResponse = [
                'success' => false,
                'message' => '❌ Failed to send. Please try again.',
            ];

            if ($request->wantsJson() || $request->input('_format') === 'json') {
                return response()->json($errorResponse, 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to submit form. Please try again.')
                ->withInput();
        }
    }

    // =========================================================================
    // FILE HANDLING METHODS
    // =========================================================================

    /**
     * Store uploaded files temporarily
     */
    private function storeTempFiles(Request $request): array
    {
        $files = [];
        
        foreach ($request->allFiles() as $field => $file) {
            if (is_array($file)) {
                foreach ($file as $index => $singleFile) {
                    if ($singleFile && $singleFile->isValid()) {
                        $path = $singleFile->store('playground/temp/' . uniqid(), 'local');
                        $files[$field . '[]'][] = $path;
                        Log::info('Playground: Temp file stored', ['field' => $field, 'path' => $path]);
                    }
                }
            } else {
                if ($file && $file->isValid()) {
                    $path = $file->store('playground/temp/' . uniqid(), 'local');
                    $files[$field][] = $path;
                    Log::info('Playground: Temp file stored', ['field' => $field, 'path' => $path]);
                }
            }
        }
        
        return $files;
    }

    /**
     * Recreate a request with files from temporary storage
     */
    private function recreateRequestWithFiles(
        array $data, 
        array $tempFiles, 
        string $email,
        string $ip = '0.0.0.0',
        ?string $userAgent = null,
        ?string $referrer = null
    ): Request {
        Log::info('Playground: Recreating request with files', [
            'temp_files' => $tempFiles,
            'ip' => $ip
        ]);
        
        $request = new Request();
        
        // Filter out internal fields before setting data
        $cleanData = collect($data)->except([
            'captcha_verified', 
            'from_playground',
            'g-recaptcha-response'
        ])->toArray();
        
        $request->replace($cleanData);
        $request->setMethod('POST');
        
        $request->server->set('REQUEST_URI', '/playground/submit');
        $request->server->set('REQUEST_METHOD', 'POST');
        $request->server->set('REMOTE_ADDR', $ip);
        
        if ($userAgent) {
            $request->server->set('HTTP_USER_AGENT', $userAgent);
        }
        
        if ($referrer) {
            $request->server->set('HTTP_REFERER', $referrer);
            $request->headers->set('Referer', $referrer);
        }
        
        foreach ($tempFiles as $field => $paths) {
            $uploadedFiles = [];
            
            foreach ($paths as $path) {
                $fullPath = storage_path('app/' . $path);
                
                if (file_exists($fullPath)) {
                    $originalName = basename($path);
                    
                    $file = new UploadedFile(
                        $fullPath,
                        $originalName,
                        mime_content_type($fullPath),
                        null,
                        true
                    );
                    
                    $uploadedFiles[] = $file;
                    
                    Log::info('Playground: File restored from temp', ['field' => $field, 'path' => $path]);
                } else {
                    Log::warning('Playground: Temp file not found', ['path' => $fullPath]);
                }
            }
            
            if (strpos($field, '[]') !== false) {
                $fieldName = str_replace('[]', '', $field);
                $request->files->set($fieldName, $uploadedFiles);
            } else {
                $request->files->set($field, $uploadedFiles[0] ?? null);
            }
        }
        
        return $request;
    }

    /**
     * Clean up temporary files
     */
    private function cleanupTempFiles(array $tempFiles): void
    {
        foreach ($tempFiles as $paths) {
            foreach ($paths as $path) {
                $fullPath = storage_path('app/' . $path);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    Log::info('Playground: Temp file cleaned up', ['path' => $path]);
                }
            }
        }
    }

    // =========================================================================
    // EXISTING HELPER METHODS
    // =========================================================================

    /**
     * Unified file upload processor.
     */
    protected function processFileUploads(
        Request $request,
        string $storagePath,
        int $maxFileSize = 10485760,
        int $maxFiles    = 5,
        bool $tempMode   = true
    ): array {
        $uploadedFiles  = [];
        $uploadMetadata = [];
        $attachments    = [];

        $allFiles = $request->allFiles();

        if (empty($allFiles)) {
            return [$uploadedFiles, $uploadMetadata, $attachments, null];
        }

        $flatFiles = [];
        foreach ($allFiles as $fieldName => $files) {
            if (in_array($fieldName, ['_token', '_method'])) {
                continue;
            }
            $filesArray = is_array($files) ? $files : [$files];
            foreach ($filesArray as $index => $file) {
                if ($file && $file->isValid()) {
                    $flatFiles[] = ['field' => $fieldName, 'index' => $index, 'file' => $file];
                }
            }
        }

        if (count($flatFiles) > $maxFiles) {
            return [[], [], [], "Maximum {$maxFiles} files allowed. You uploaded " . count($flatFiles) . " files."];
        }

        foreach ($flatFiles as $item) {
            $fieldName    = $item['field'];
            $index        = $item['index'];
            $uploadedFile = $item['file'];

            if ($uploadedFile->getSize() > $maxFileSize) {
                $maxMb = round($maxFileSize / 1048576);
                return [[], [], [], "File '{$uploadedFile->getClientOriginalName()}' is too large. Maximum size is {$maxMb}MB."];
            }

            $originalName = $uploadedFile->getClientOriginalName();
            $safeName     = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $originalName);
            $fieldSlug    = preg_replace('/[^a-zA-Z0-9]/', '_', $fieldName);
            $filename     = time() . '_' . uniqid() . '_' . $fieldSlug . '_' . $index . '_' . $safeName;

            try {
                $path         = $uploadedFile->storeAs($storagePath, $filename, 'public');
                $absolutePath = Storage::disk('public')->path($path);

                Log::info('Playground: File stored', [
                    'field'    => $fieldName,
                    'original' => $originalName,
                    'size'     => $uploadedFile->getSize(),
                    'path'     => $path,
                ]);

                $metadata = [
                    'name'          => $originalName,
                    'filename'      => $filename,
                    'path'          => $path,
                    'absolute_path' => $absolutePath,
                    'size'          => $uploadedFile->getSize(),
                    'type'          => $uploadedFile->getMimeType(),
                    'field_name'    => $fieldName,
                    'field_index'   => $index,
                ];

                $uploadedFiles[]  = $absolutePath;
                $uploadMetadata[] = $metadata;
                $attachments[]    = [
                    'file' => $absolutePath,
                    'name' => $originalName,
                    'mime' => $uploadedFile->getMimeType(),
                ];

            } catch (\Exception $e) {
                Log::error('Playground: File store failed: ' . $e->getMessage(), ['field' => $fieldName, 'original' => $originalName]);
                return [[], [], [], 'Failed to upload file. Please try again.'];
            }
        }

        return [$uploadedFiles, $uploadMetadata, $attachments, null];
    }

    /**
     * Build standard formData array from request.
     */
    protected function buildFormData(
        Request $request,
        string $recipientEmail,
        string $formName,
        array $submissionData,
        array $specialData,
        array $uploadMetadata
    ): array {
        $message = $submissionData['message'] ?? $submissionData['body'] ?? null;

        $skipKeys  = ['recipient_email', '_token', '_method', 'captcha_verified', 'from_playground'];
        $allFields = [];

        if (!empty($message)) {
            $allFields['message'] = $message;
        }

        foreach ($submissionData as $key => $value) {
            if (in_array($key, $skipKeys)) continue;
            if ($key === 'message' || $key === 'body') continue;
            $allFields[$key] = $value;
        }

        return [
            'name'                 => $request->input('name') ?? $request->input('full_name') ?? 'Anonymous',
            'sender_email'         => $request->input('email') ?? $request->input('sender_email') ?? '',
            'message'              => $message ?? 'No message provided',
            'recipient_email'      => $recipientEmail,
            'submitted_at'         => now()->format('Y-m-d H:i:s'),
            'app_url'              => config('app.url'),
            'form_name'            => $formName,
            'all_fields'           => $allFields,
            'special_fields'       => $specialData,
            'has_attachments'      => !empty($uploadMetadata),
            'attachment_count'     => count($uploadMetadata),
            'attachments_metadata' => $uploadMetadata,
        ];
    }

    /**
     * Send auto-response email to the form submitter.
     */
    protected function sendAutoResponse(string $visitorEmail, array $formData, array $specialData): void
    {
        try {
            $rawValue = $specialData['_auto-response'] ?? "Thank you for your submission. We'll get back to you soon.";

            if (str_contains($rawValue, '|')) {
                [$autoResponseMessage, $customSubject] = array_map('trim', explode('|', $rawValue, 2));
            } else {
                $autoResponseMessage = trim($rawValue);
                $customSubject       = null;
            }

            $defaultSubject = 'We received your message — ' . ($formData['form_name'] ?? config('app.name'));
            $subject        = $customSubject ?: $defaultSubject;

            $placeholders = ['{name}', '{email}', '{date}'];
            $replacements = [
                $formData['name']         ?? 'Visitor',
                $formData['sender_email'] ?? '',
                now()->format('Y-m-d'),
            ];

            $autoResponseMessage = str_replace($placeholders, $replacements, $autoResponseMessage);
            $subject             = str_replace($placeholders, $replacements, $subject);

            Log::info('Playground: Sending auto-response', ['to' => $visitorEmail, 'subject' => $subject]);

            Mail::html(
                '<div style="font-family:sans-serif;font-size:15px;line-height:1.6;color:#333;">'
                    . nl2br(e($autoResponseMessage))
                    . '</div>',
                function ($message) use ($visitorEmail, $subject) {
                    $message->to($visitorEmail)->subject($subject);
                }
            );

            Log::info('Playground: Auto-response sent successfully', ['to' => $visitorEmail]);

        } catch (\Exception $e) {
            Log::error('Playground: Auto-response failed: ' . $e->getMessage(), ['to' => $visitorEmail]);
        }
    }

    /**
     * Check ALL submitted field values against the blacklist.
     */
    protected function handleBlacklist($blacklist, Request $request, array $submissionData): bool
    {
        $bannedTerms = is_array($blacklist)
            ? $blacklist
            : array_map('trim', explode(',', $blacklist));

        $bannedTerms = array_filter($bannedTerms, fn($t) => trim($t) !== '');

        if (empty($bannedTerms)) {
            return false;
        }

        $allValues = array_filter(
            $request->except(['_token', '_method', 'recipient_email', 'form_slug', 'captcha_verified', 'from_playground']),
            fn($v, $k) => !str_starts_with((string)$k, '_') && (!is_array($v) || count($v) > 0),
            ARRAY_FILTER_USE_BOTH
        );

        foreach ($allValues as $key => $value) {
            $valueStr = is_array($value) ? implode(' ', $value) : (string) $value;

            foreach ($bannedTerms as $term) {
                $term = trim($term);
                if ($term === '') continue;

                if (stripos($valueStr, $term) !== false) {
                    Log::info('Playground: Blacklist triggered — blocking submission', [
                        'field' => $key,
                        'term'  => $term,
                    ]);
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Handle response based on format and redirect
     */
    protected function handleResponse(Request $request, array $specialData, string $email)
    {
        // Clean response - no internal flags
        $response = [
            'success'  => true,
            'message'  => 'Form submitted successfully!',
        ];

        if (!empty($specialData['_next'])) {
            $response['redirect'] = $specialData['_next'];
        }

        if ($request->wantsJson() || ($specialData['_format'] ?? '') === 'json') {
            return response()->json($response);
        }

        if (!empty($specialData['_next'])) {
            return redirect()->away($specialData['_next']);
        }

        return redirect()->route('playground.form.submitted')
            ->with('success', 'Form submitted successfully! Check your email.');
    }

    /**
     * Send verification email.
     */
    protected function sendVerification(string $email): void
    {
        $token    = Str::random(32);
        $cacheKey = 'playground_verify_' . md5($email);

        Cache::put($cacheKey, [
            'token'    => $token,
            'verified' => false,
        ], now()->addHours(24));

        $verifyUrl = route('playground.confirm-email', [
            'email' => $email,
            'token' => $token,
        ]);

        try {
            Mail::to($email)->send(new PlaygroundVerificationMail($email, $verifyUrl));
            Log::info('Playground: verification email sent', ['email' => $email]);
        } catch (\Exception $e) {
            Log::error('Playground: verification email failed — ' . $e->getMessage());
        }
    }

    /**
     * Delete a list of files safely
     */
    protected function cleanupFiles(array $files): void
    {
        foreach ($files as $file) {
            if (file_exists($file)) {
                try {
                    unlink($file);
                    Log::info('Playground: Temp file deleted', ['file' => $file]);
                } catch (\Exception $e) {
                    Log::warning('Playground: Failed to delete temp file', ['file' => $file]);
                }
            }
        }
    }
}