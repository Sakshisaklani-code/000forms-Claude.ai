<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Mail\PlaygroundFormSubmissionMail;
use App\Mail\PlaygroundVerificationMail;
use App\Models\Form;
use App\Models\Submission;
use App\Services\RecaptchaService;

class PlaygroundController extends Controller
{
    protected RecaptchaService $recaptcha;

    public function __construct(RecaptchaService $recaptcha)
    {
        $this->recaptcha = $recaptcha;
    }

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
     * FIX: Changed cache TTL from 7 days to FOREVER — verified emails never expire
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
     * Handle form submission to email endpoint (from external forms)
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

        // -----------------------------------------------------------------
        // reCAPTCHA VERIFICATION
        // Skip if user adds: <input type="hidden" name="_captcha" value="false">
        // -----------------------------------------------------------------
        $allData = $request->except(['_token']);

        if (!$this->recaptcha->isDisabledByUser($allData)) {
            $token = $request->input('g-recaptcha-response', '');
            if (empty($token) || !$this->recaptcha->verify($token, $request->ip())) {
                Log::warning('reCAPTCHA failed on email endpoint', ['email' => $email, 'ip' => $request->ip()]);

                if ($request->wantsJson() || $request->input('_format') === 'json') {
                    return response()->json([
                        'success' => false,
                        'message' => 'reCAPTCHA verification failed. Please try again.',
                    ], 422);
                }

                return back()->with('error', 'reCAPTCHA verification failed. Please try again.')->withInput();
            }
        } else {
            Log::info('reCAPTCHA skipped via _captcha=false', ['email' => $email]);
        }

        try {
            $specialFieldKeys = [
                '_subject', '_replyto', '_next', '_cc', '_bcc',
                '_template', '_format', '_blacklist', '_auto-response',
                '_auto-reponse', '_captcha',
            ];

            $submissionData = [];
            $specialData    = [];

            foreach ($allData as $key => $value) {
                if ($key === 'g-recaptcha-response') continue;

                if (in_array($key, $specialFieldKeys)) {
                    $normalizedKey               = ($key === '_auto-reponse') ? '_auto-response' : $key;
                    $specialData[$normalizedKey] = $value;
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
                    return $this->handleResponse($request, $specialData, $email);
                }
            }

            [$uploadedFiles, $uploadMetadata, $attachments, $fileError] = $this->processFileUploads(
                $request,
                'playground/temp/' . date('Y/m/d')
            );

            if ($fileError) {
                if ($request->wantsJson() || $request->input('_format') === 'json') {
                    return response()->json(['success' => false, 'message' => $fileError], 422);
                }
                return redirect()->back()->with('error', $fileError)->withInput();
            }

            $formData = $this->buildFormData($request, $email, 'Playground Form', $submissionData, $specialData, $uploadMetadata);

            $this->sendFormSubmissionEmail($email, $formData, $attachments, $specialData);

            if (!empty($specialData['_auto-response']) && !empty($formData['sender_email'])) {
                $this->sendAutoResponse($formData['sender_email'], $formData, $specialData);
            }

            Log::info('Playground email submission sent', [
                'recipient'      => $email,
                'attachments'    => count($attachments),
                'special_fields' => array_keys($specialData),
            ]);

            $this->cleanupFiles($uploadedFiles);
            $this->cleanupTempDirectories();

            return $this->handleResponse($request, $specialData, $email);

        } catch (\Exception $e) {
            Log::error('Playground email submission failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            if ($request->wantsJson() || $request->input('_format') === 'json') {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to submit form. Please try again.',
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to submit form. Please try again.')
                ->withInput();
        }
    }

    /**
     * Main submit method - routes to appropriate handler
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
     * Handle playground-specific submissions (with verification)
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

        if (!$data || empty($data['verified'])) {
            Log::warning('Playground: submit without verification', ['email' => $recipientEmail]);
            return response()->json([
                'success' => false,
                'message' => '⚠️ Please verify your email first.',
            ], 403);
        }

        // -----------------------------------------------------------------
        // reCAPTCHA VERIFICATION
        // Skip if user adds: <input type="hidden" name="_captcha" value="false">
        // -----------------------------------------------------------------
        $allData = $request->except(['_token']);

        if (!$this->recaptcha->isDisabledByUser($allData)) {
            $token = $request->input('g-recaptcha-response', '');
            if (empty($token) || !$this->recaptcha->verify($token, $request->ip())) {
                Log::warning('reCAPTCHA failed on playground submission', [
                    'email' => $recipientEmail,
                    'ip'    => $request->ip(),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => '⚠️ reCAPTCHA verification failed. Please try again.',
                ], 422);
            }
        } else {
            Log::info('reCAPTCHA skipped via _captcha=false', ['email' => $recipientEmail]);
        }

        try {
            Log::info('Playground submission data', [
                'all_input'    => $request->except(['_token']),
                'all_files'    => array_keys($request->allFiles()),
                'recipient'    => $recipientEmail,
                'method'       => $request->method(),
                'content_type' => $request->header('Content-Type'),
            ]);

            $specialFieldKeys = [
                '_subject', '_replyto', '_next', '_cc', '_bcc',
                '_template', '_format', '_blacklist', '_auto-response',
                '_auto-reponse', '_captcha',
            ];

            $submissionData = [];
            $specialData    = [];

            foreach ($allData as $key => $value) {
                if ($key === 'g-recaptcha-response') continue;

                if (in_array($key, $specialFieldKeys)) {
                    $normalizedKey               = ($key === '_auto-reponse') ? '_auto-response' : $key;
                    $specialData[$normalizedKey] = $value;
                    Log::info('Special field found', ['key' => $normalizedKey, 'original_key' => $key, 'value' => $value]);
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
                    return response()->json(['success' => true, 'message' => '✅ Message sent successfully!']);
                }
            }

            [$uploadedFiles, $uploadMetadata, $attachments, $fileError] = $this->processFileUploads(
                $request,
                'playground/temp/' . date('Y/m/d')
            );

            if ($fileError) {
                Log::warning('File upload error', ['error' => $fileError]);
                return response()->json(['success' => false, 'message' => $fileError], 422);
            }

            $formData = $this->buildFormData($request, $recipientEmail, 'Playground Form', $submissionData, $specialData, $uploadMetadata);

            Log::info('Form data prepared', [
                'name'              => $formData['name'],
                'has_sender_email'  => !empty($formData['sender_email']),
                'attachments_count' => count($attachments),
            ]);

            try {
                Log::info('Attempting to send email', ['to' => $recipientEmail]);
                $mail = new \App\Mail\PlaygroundFormSubmissionMail($formData, $attachments, $specialData);
                Mail::to($recipientEmail)->send($mail);
                Log::info('Email sent successfully', ['to' => $recipientEmail]);
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]);
                throw $e;
            }

            if (!empty($specialData['_auto-response']) && !empty($formData['sender_email'])) {
                try {
                    $this->sendAutoResponse($formData['sender_email'], $formData, $specialData);
                    Log::info('Auto-response sent', ['to' => $formData['sender_email']]);
                } catch (\Exception $e) {
                    Log::error('Auto-response failed: ' . $e->getMessage());
                }
            }

            $this->cleanupFiles($uploadedFiles);

            Log::info('Playground: submission completed successfully', [
                'recipient'   => $recipientEmail,
                'attachments' => count($attachments),
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '✅ Message sent successfully!',
                ]);
            }

            if (!empty($specialData['_next'])) {
                return redirect()->away($specialData['_next']);
            }

            return redirect()->route('playground.form.submitted')
                ->with('success', 'Form submitted successfully!');

        } catch (\Exception $e) {
            Log::error('Playground: submission failed — ' . $e->getMessage(), [
                'exception_class' => get_class($e),
                'file'            => $e->getFile(),
                'line'            => $e->getLine(),
                'recipient'       => $recipientEmail ?? 'unknown',
            ]);

            return response()->json([
                'success' => false,
                'message' => '❌ Failed to send. Error: ' . $e->getMessage(),
            ], 500);
        }
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

        // -----------------------------------------------------------------
        // reCAPTCHA VERIFICATION
        // Skip if user adds: <input type="hidden" name="_captcha" value="false">
        // -----------------------------------------------------------------
        $allData = $request->except(['_token']);

        if (!$this->recaptcha->isDisabledByUser($allData)) {
            $token = $request->input('g-recaptcha-response', '');
            if (empty($token) || !$this->recaptcha->verify($token, $request->ip())) {
                return response()->json([
                    'success' => false,
                    'message' => 'reCAPTCHA verification failed. Please try again.',
                ], 422);
            }
        }

        try {
            $specialFieldKeys = [
                '_subject', '_replyto', '_next', '_cc', '_bcc',
                '_template', '_format', '_blacklist', '_auto-response',
                '_auto-reponse', '_captcha',
            ];

            $submissionData = [];
            $specialData    = [];

            foreach ($allData as $key => $value) {
                if ($key === 'g-recaptcha-response') continue;

                if (in_array($key, $specialFieldKeys)) {
                    $normalizedKey               = ($key === '_auto-reponse') ? '_auto-response' : $key;
                    $specialData[$normalizedKey] = $value;
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
                            'form_name'    => $form->title ?? 'Form',
                        ];
                        $this->sendAutoResponse($senderEmail, $blockedFormData, $specialData);
                    }
                    return $this->handleResponse($request, $specialData, $form->recipient_email);
                }
            }

            $attachments    = [];
            $uploadMetadata = [];
            $uploadedFiles  = [];

            if ($form->allow_file_upload) {
                $storagePath = 'uploads/' . $form->id . '/' . date('Y/m/d');
                $maxFileSize = ($form->max_file_size ?? 10) * 1024 * 1024;
                $maxFiles    = $form->max_files ?? 5;

                [$uploadedFiles, $uploadMetadata, $attachments, $fileError] = $this->processFileUploads(
                    $request,
                    $storagePath,
                    $maxFileSize,
                    $maxFiles,
                    false
                );

                if ($fileError) {
                    return response()->json(['success' => false, 'message' => $fileError], 422);
                }
            }

            if ($form->store_submissions) {
                Submission::create([
                    'form_id'    => $form->id,
                    'data'       => $submissionData,
                    'metadata'   => [
                        'special_fields'  => $specialData,
                        'has_attachments' => !empty($attachments),
                        'attachments'     => $uploadMetadata,
                        'captcha_skipped' => $this->recaptcha->isDisabledByUser($allData),
                    ],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referrer'   => $request->header('Referer'),
                ]);
            }

            $formData = $this->buildFormData($request, $form->recipient_email, $form->title, $submissionData, $specialData, $uploadMetadata);

            $this->sendFormSubmissionEmail($form->recipient_email, $formData, $attachments, $specialData);

            if (!empty($specialData['_auto-response']) && !empty($formData['sender_email'])) {
                $this->sendAutoResponse($formData['sender_email'], $formData, $specialData);
            }

            Log::info('External form submission sent', [
                'form_id'     => $form->id,
                'recipient'   => $form->recipient_email,
                'attachments' => count($attachments),
            ]);

            return $this->handleResponse($request, $specialData, $form->recipient_email);

        } catch (\Exception $e) {
            Log::error('External form submission failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to process submission.'], 500);
        }
    }

    // =========================================================================
    // PRIVATE / PROTECTED HELPERS
    // =========================================================================

    /**
     * Unified file upload processor.
     * Returns: [uploadedFilePaths[], uploadMetadata[], attachments[], errorMessage|null]
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

                Log::info('File stored', [
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
                Log::error('File store failed: ' . $e->getMessage(), ['field' => $fieldName, 'original' => $originalName]);
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

        $skipKeys  = ['recipient_email', '_token', '_method'];
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
     * Send form submission email
     */
    protected function sendFormSubmissionEmail(string $recipient, array $formData, array $attachments, array $specialData): void
    {
        $mail = new \App\Mail\PlaygroundFormSubmissionMail($formData, $attachments, $specialData);
        Mail::to($recipient)->send($mail);
    }

    /**
     * Send auto-response email to the form submitter.
     * Supports pipe-separated subject: "Message body|Custom Subject"
     * Supports placeholders: {name}, {email}, {date}
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

            Log::info('Sending auto-response', ['to' => $visitorEmail, 'subject' => $subject]);

            Mail::html(
                '<div style="font-family:sans-serif;font-size:15px;line-height:1.6;color:#333;">'
                    . nl2br(e($autoResponseMessage))
                    . '</div>',
                function ($message) use ($visitorEmail, $subject) {
                    $message->to($visitorEmail)->subject($subject);
                }
            );

            Log::info('Auto-response sent successfully', ['to' => $visitorEmail]);

        } catch (\Exception $e) {
            Log::error('Auto-response failed: ' . $e->getMessage(), ['to' => $visitorEmail]);
        }
    }

    /**
     * Check ALL submitted field values against the blacklist.
     * Returns true if submission should be blocked.
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
            $request->except(['_token', '_method', 'recipient_email', 'form_slug']),
            fn($v, $k) => !str_starts_with((string)$k, '_') && (!is_array($v) || count($v) > 0),
            ARRAY_FILTER_USE_BOTH
        );

        foreach ($allValues as $key => $value) {
            $valueStr = is_array($value) ? implode(' ', $value) : (string) $value;

            foreach ($bannedTerms as $term) {
                $term = trim($term);
                if ($term === '') continue;

                if (stripos($valueStr, $term) !== false) {
                    Log::info('Blacklist triggered — blocking submission', [
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
        if ($request->wantsJson() || ($specialData['_format'] ?? '') === 'json') {
            return response()->json([
                'success'  => true,
                'message'  => 'Form submitted successfully!',
                'redirect' => $specialData['_next'] ?? null,
            ]);
        }

        if (!empty($specialData['_next'])) {
            return redirect()->away($specialData['_next']);
        }

        return redirect()->route('playground.form.submitted')
            ->with('success', 'Form submitted successfully! Check your email.');
    }

    /**
     * Send verification email.
     * Token cache = 24 hours (to click link). On confirmation → stored forever.
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
                    Log::info('Temp file deleted', ['file' => $file]);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete temp file', ['file' => $file]);
                }
            }
        }
    }

    /**
     * Clean up empty temporary directories
     */
    protected function cleanupTempDirectories(): void
    {
        try {
            $tempBase = Storage::disk('public')->path('playground/temp');
            if (!is_dir($tempBase)) return;

            foreach (glob($tempBase . '/*', GLOB_ONLYDIR) as $year) {
                foreach (glob($year . '/*', GLOB_ONLYDIR) as $month) {
                    foreach (glob($month . '/*', GLOB_ONLYDIR) as $day) {
                        if (count(glob($day . '/*')) === 0) rmdir($day);
                    }
                    if (count(glob($month . '/*')) === 0) rmdir($month);
                }
                if (count(glob($year . '/*')) === 0) rmdir($year);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to cleanup temp directories: ' . $e->getMessage());
        }
    }
}