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
use App\Models\Form;
use App\Models\Submission;

class PlaygroundController extends Controller
{
    public function index()
    {
        return view('pages.playground');
    }

    public function formSubmitted()
    {
        return view('pages.form-submitted');
    }

    public function formEndpointInfo(string $email)
    {
        $email    = strtolower(trim($email));
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);
        $verified = $data && !empty($data['verified']);

        return view('pages.form-endpoint-info', compact('email', 'verified'));
    }

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

        Cache::put($cacheKey, array_merge($data, ['verified' => true]), now()->addDays(7));
        Log::info('Playground: email verified', ['email' => $email]);

        return view('pages.playground-verify-result', [
            'success' => true,
            'message' => 'Your email has been verified! You can now close this tab and submit the form.',
            'email'   => $email,
        ]);
    }

    public function checkVerified(Request $request)
    {
        $email    = strtolower(trim($request->query('email', '')));
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        return response()->json([
            'verified' => $data && !empty($data['verified']),
        ]);
    }

    public function submit(Request $request)
    {
        // Check if this is a playground submission or external form submission
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

        try {
            $skip        = ['recipient_email', '_token', '_method'];
            $extraFields = [];
            foreach ($request->except($skip) as $key => $value) {
                if (!str_starts_with($key, '_')) {
                    $extraFields[$key] = $value;
                }
            }

            $formData = [
                'name'            => $request->input('name') ?? $request->input('full_name') ?? 'Anonymous',
                'sender_email'    => $request->input('email') ?? $request->input('sender_email') ?? '',
                'message'         => $request->input('message') ?? $request->input('body') ?? json_encode($extraFields),
                'recipient_email' => $recipientEmail,
                'submitted_at'    => now()->format('Y-m-d H:i:s'),
                'app_url'         => config('app.url'),
                'extra_fields'    => array_filter($extraFields, fn($k) => !in_array($k, ['name', 'full_name', 'email', 'message', 'body']), ARRAY_FILTER_USE_KEY),
            ];

            $attachments = [];
            foreach ($request->allFiles() as $files) {
                foreach ((array) $files as $file) {
                    if ($file && $file->isValid()) {
                        $attachments[] = [
                            'file' => $file->path(),
                            'name' => $file->getClientOriginalName(),
                            'mime' => $file->getMimeType(),
                        ];
                    }
                }
            }

            Mail::to($recipientEmail)->send(new PlaygroundFormSubmissionMail($formData, $attachments));
            Log::info('Playground: submission sent', ['recipient' => $recipientEmail]);

            return response()->json(['success' => true, 'message' => '✅ Message sent successfully!']);

        } catch (\Exception $e) {
            Log::error('Playground: submission failed — ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '❌ Failed to send. Please try again.',
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
            return response()->json([
                'success' => false,
                'message' => 'Form not found.',
            ], 404);
        }

        // Check if form can accept submissions
        if (!$form->canAcceptSubmissions()) {
            if (!$form->email_verified) {
                return response()->json([
                    'success' => false,
                    'message' => 'Form email not verified.',
                ], 403);
            }
            return response()->json([
                'success' => false,
                'message' => 'Form is not accepting submissions.',
            ], 403);
        }

        // Check domain restrictions
        if (!$form->isDomainAllowed($request->header('Referer'))) {
            return response()->json([
                'success' => false,
                'message' => 'Submissions from this domain are not allowed.',
            ], 403);
        }

        try {
            // Process the submission data
            $allData = $request->except(['_token', 'form_slug']);
            
            // Extract form data
            $formData = [
                'name'            => $request->input('name') ?? $request->input('full_name') ?? 'Anonymous',
                'sender_email'    => $request->input('email') ?? $request->input('sender_email') ?? '',
                'message'         => $request->input('message') ?? $request->input('body') ?? 'No message provided',
                'recipient_email' => $form->recipient_email,
                'submitted_at'    => now()->format('Y-m-d H:i:s'),
                'app_url'         => config('app.url'),
                'form_name'       => $form->title,
                'all_fields'      => $allData,
            ];

            // Handle file attachments
            $attachments = [];
            $uploadMetadata = [];
            
            if ($form->allow_file_upload) {
                foreach ($request->allFiles() as $fieldName => $files) {
                    $filesArray = is_array($files) ? $files : [$files];
                    
                    foreach ($filesArray as $uploadedFile) {
                        if (!$uploadedFile || !$uploadedFile->isValid()) {
                            continue;
                        }
                        
                        // Check file size
                        $maxFileSize = ($form->max_file_size ?? 10) * 1024 * 1024;
                        if ($uploadedFile->getSize() > $maxFileSize) {
                            continue;
                        }
                        
                        // Store file temporarily
                        $originalName = $uploadedFile->getClientOriginalName();
                        $filename = time() . '_' . uniqid() . '_' . $originalName;
                        $path = $uploadedFile->storeAs('temp/' . $form->id, $filename, 'public');
                        $absolutePath = Storage::disk('public')->path($path);
                        
                        $attachments[] = [
                            'file' => $absolutePath,
                            'name' => $originalName,
                            'mime' => $uploadedFile->getMimeType(),
                        ];
                        
                        $uploadMetadata[] = [
                            'name' => $originalName,
                            'filename' => $filename,
                            'path' => $path,
                            'size' => $uploadedFile->getSize(),
                            'type' => $uploadedFile->getMimeType(),
                        ];
                    }
                }
            }

            // Store submission if enabled
            if ($form->store_submissions) {
                Submission::create([
                    'form_id' => $form->id,
                    'data' => $allData,
                    'metadata' => [
                        'has_attachments' => !empty($attachments),
                        'attachments' => $uploadMetadata,
                    ],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'referrer' => $request->header('Referer'),
                ]);
            }

            // Send email
            Mail::to($form->recipient_email)->send(new PlaygroundFormSubmissionMail($formData, $attachments));
            
            // Clean up temporary files
            foreach ($attachments as $attachment) {
                if (file_exists($attachment['file'])) {
                    unlink($attachment['file']);
                }
            }

            Log::info('External form submission sent', [
                'form_id' => $form->id,
                'recipient' => $form->recipient_email
            ]);

            // Return appropriate response
            if ($request->wantsJson() || $request->input('_format') === 'json') {
                return response()->json([
                    'success' => true,
                    'message' => $form->success_message ?? 'Form submitted successfully!',
                ]);
            }

            $redirectUrl = $request->input('_next') ?? $form->redirect_url;
            if ($redirectUrl) {
                return redirect()->away($redirectUrl);
            }

            return redirect()->route('playground.form-submitted');

        } catch (\Exception $e) {
            Log::error('External form submission failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to process submission.',
            ], 500);
        }
    }

    /**
     * Handle form submission to email endpoint (from external forms)
     */
    public function handleEmailSubmission(Request $request, string $email)
    {
        $email = strtolower(trim($email));
        
        Log::info('Playground email submission received', [
            'email' => $email,
            'ip' => $request->ip(),
            'has_files' => $request->hasFile('file') ? 'yes' : 'no',
        ]);

        // Check if email is verified
        $cacheKey = 'playground_verify_' . md5($email);
        $data = Cache::get($cacheKey);

        if (!$data || empty($data['verified'])) {
            Log::warning('Playground: submission to unverified email', ['email' => $email]);
            
            // Redirect to verification page
            return redirect()->route('playground.endpoint.info', ['email' => $email])
                ->with('error', 'Please verify your email first.');
        }

        try {
            // Process the submission
            $skip = ['_token', '_method'];
            $extraFields = [];
            foreach ($request->except($skip) as $key => $value) {
                if (!str_starts_with($key, '_')) {
                    $extraFields[$key] = $value;
                }
            }

            $formData = [
                'name' => $request->input('name') ?? $request->input('full_name') ?? 'Anonymous',
                'sender_email' => $request->input('email') ?? $request->input('sender_email') ?? '',
                'message' => $request->input('message') ?? $request->input('body') ?? json_encode($extraFields),
                'recipient_email' => $email,
                'submitted_at' => now()->format('Y-m-d H:i:s'),
                'app_url' => config('app.url'),
                'extra_fields' => array_filter($extraFields, fn($k) => !in_array($k, ['name', 'full_name', 'email', 'message', 'body']), ARRAY_FILTER_USE_KEY),
            ];

            // Handle file attachments
            $attachments = [];
            foreach ($request->allFiles() as $files) {
                foreach ((array) $files as $file) {
                    if ($file && $file->isValid()) {
                        $attachments[] = [
                            'file' => $file->path(),
                            'name' => $file->getClientOriginalName(),
                            'mime' => $file->getMimeType(),
                        ];
                    }
                }
            }

            // Send email
            Mail::to($email)->send(new PlaygroundFormSubmissionMail($formData, $attachments));
            
            Log::info('Playground email submission sent', ['recipient' => $email]);

            // Check response format
            if ($request->wantsJson() || $request->input('_format') === 'json') {
                return response()->json([
                    'success' => true,
                    'message' => 'Form submitted successfully!',
                ]);
            }

            // Check for redirect URL in the form data
            $redirectUrl = $request->input('_next');
            if ($redirectUrl) {
                return redirect()->away($redirectUrl);
            }

            // Redirect to the form submitted page
            return redirect()->route('playground.form.submitted')
                ->with('success', 'Form submitted successfully! Check your email.');

        } catch (\Exception $e) {
            Log::error('Playground email submission failed: ' . $e->getMessage());
            
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
}