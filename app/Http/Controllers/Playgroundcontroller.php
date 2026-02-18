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
     */
    public function formEndpointInfo(string $email)
    {
        $email = strtolower(trim($email));
        $verified = $this->isEmailVerified($email);
        
        // If not verified, automatically send verification
        if (!$verified) {
            $this->sendVerification($email);
        }

        return view('pages.form-endpoint-info', compact('email', 'verified'));
    }

    /**
     * POST /f/{email}
     * The standalone form endpoint — works like formsubmit.co.
     */
    public function formEndpoint(Request $request, string $email)
    {
        $email = strtolower(trim($email));
        
        // Log the request for debugging
        Log::info('Form endpoint hit', [
            'email' => $email,
            'method' => $request->method(),
            'ip' => $request->ip()
        ]);
        
        // Check if email is verified
        if (!$this->isEmailVerified($email)) {
            // Auto-send verification if not verified
            $this->sendVerification($email);
            
            Log::info('Unverified email attempt', ['email' => $email]);
            
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email not verified. Please check your inbox for a verification link.',
                    'requires_verification' => true,
                    'email' => $email
                ], 403);
            }

            return redirect()->route('playground.endpoint.info', $email)
                ->with('warning', 'Please verify your email before submissions are accepted.');
        }

        // Process the form submission
        return $this->processFormSubmission($request, $email);
    }

    /**
     * Check if an email is verified
     */
    private function isEmailVerified(string $email): bool
    {
        $cacheKey = 'playground_verify_' . md5($email);
        $data = Cache::get($cacheKey);
        
        $verified = $data && !empty($data['verified']);
        
        Log::debug('Email verification check', [
            'email' => $email,
            'verified' => $verified,
            'cache_key' => $cacheKey,
            'cache_data' => $data
        ]);
        
        return $verified;
    }

    /**
     * Process the actual form submission
     */
    private function processFormSubmission(Request $request, string $email)
    {
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
            'name' => $fields['name'] ?? $fields['full_name'] ?? 'Anonymous',
            'sender_email' => $fields['email'] ?? $fields['email_address'] ?? 'noreply@unknown.com',
            'message' => $fields['message'] ?? $fields['body'] ?? json_encode($fields),
            'recipient_email' => $email,
            'submitted_at' => now()->format('Y-m-d H:i:s'),
            'app_url' => config('app.url'),
            'extra_fields' => array_filter($fields, function($k) {
                return !in_array($k, ['name', 'full_name', 'email', 'email_address', 'message', 'body']);
            }, ARRAY_FILTER_USE_KEY),
        ];

        // Handle file uploads
        $fileAttachments = [];
        foreach ($request->allFiles() as $fileKey => $file) {
            if (!is_array($file)) {
                $file = [$file];
            }
            foreach ($file as $f) {
                if ($f && $f->isValid()) {
                    $fileAttachments[] = [
                        'file' => $f->path(),
                        'name' => $f->getClientOriginalName(),
                        'mime' => $f->getMimeType(),
                    ];
                }
            }
        }

        try {
            Mail::to($email)->send(new PlaygroundFormSubmissionMail($formData, $fileAttachments));
            Log::info('Form endpoint submission successful', ['recipient' => $email]);

            $next = $request->input('_next', route('playground.form.submitted'));

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Form submitted successfully!'
                ]);
            }

            return redirect($next)->with('success', 'Your message has been sent!');

        } catch (\Exception $e) {
            Log::error('Form endpoint submission failed: ' . $e->getMessage());

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Failed to send email: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to send your message. Please try again.');
        }
    }

    /**
     * GET /form-submitted
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
        $email = strtolower(trim($email));
        $token = Str::random(32);
        $cacheKey = 'playground_verify_' . md5($email);

        // Store verification data with longer expiry
        Cache::put($cacheKey, [
            'token' => $token, 
            'verified' => false,
            'email' => $email,
            'created_at' => now()->timestamp
        ], now()->addHours(24)); // 24 hours to verify

        $verifyUrl = route('playground.confirm-email', [
            'email' => $email, 
            'token' => $token
        ]);

        try {
            Mail::to($email)->send(new PlaygroundVerificationMail($email, $verifyUrl));
            Log::info('Verification email sent', ['email' => $email, 'token' => $token]);
        } catch (\Exception $e) {
            Log::error('Verification email failed: ' . $e->getMessage());
        }
    }

    // =========================================================
    //  Playground page routes
    // =========================================================

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid email address.'], 422);
        }

        $email = strtolower(trim($request->email));
        $limitKey = 'playground_verify_limit_' . md5($email);
        $attempts = Cache::get($limitKey, 0);

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
        $email = strtolower(trim($request->query('email', '')));
        $token = $request->query('token', '');
        $cacheKey = 'playground_verify_' . md5($email);
        $data = Cache::get($cacheKey);

        Log::info('Confirm email attempt', [
            'email' => $email,
            'token_provided' => $token,
            'token_stored' => $data['token'] ?? null,
            'data_exists' => !is_null($data)
        ]);

        if (!$data || ($data['token'] ?? '') !== $token) {
            return view('pages.playground-verify-result', [
                'success' => false,
                'message' => 'This verification link is invalid or has expired.',
                'email' => $email,
            ]);
        }

        // Mark as verified and extend cache to 7 days
        Cache::put($cacheKey, array_merge($data, ['verified' => true]), now()->addDays(7));
        
        Log::info('Email verified successfully', ['email' => $email]);

        return view('pages.playground-verify-result', [
            'success' => true,
            'message' => 'Your email has been verified! You can now close this tab and submit the form.',
            'email' => $email,
        ]);
    }

    public function checkVerified(Request $request)
    {
        $email = strtolower(trim($request->query('email', '')));
        
        if (empty($email)) {
            return response()->json(['verified' => false, 'error' => 'Email required']);
        }
        
        $verified = $this->isEmailVerified($email);
        
        return response()->json([
            'verified' => $verified,
            'email' => $email
        ]);
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:5',
            'recipient_email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $recipientEmail = strtolower(trim($request->recipient_email));

        // Double-check verification
        if (!$this->isEmailVerified($recipientEmail)) {
            Log::warning('Submission attempted with unverified email', ['email' => $recipientEmail]);
            
            return response()->json([
                'success' => false,
                'message' => '⚠️ Recipient email not verified. Please verify it first.',
                'requires_verification' => true,
                'email' => $recipientEmail
            ], 403);
        }

        try {
            $formData = [
                'name' => $request->name,
                'sender_email' => $request->email,
                'message' => $request->message,
                'recipient_email' => $recipientEmail,
                'submitted_at' => now()->format('Y-m-d H:i:s'),
                'app_url' => config('app.url'),
                'extra_fields' => array_filter(
                    $request->except(['name', 'email', 'message', 'recipient_email', '_token', '_method']),
                    function($k) {
                        return !str_starts_with($k, '_');
                    },
                    ARRAY_FILTER_USE_KEY
                ),
            ];

            $fileAttachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if ($file && $file->isValid()) {
                        $fileAttachments[] = [
                            'file' => $file->path(),
                            'name' => $file->getClientOriginalName(),
                            'mime' => $file->getMimeType(),
                        ];
                    }
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