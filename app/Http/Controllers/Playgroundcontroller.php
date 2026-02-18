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
     * Send a verification email to the recipient before allowing submissions.
     */
    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address.',
            ], 422);
        }

        $email = strtolower($request->email);

        // Rate-limit: max 3 verification attempts per email per 10 minutes
        $rateLimitKey = 'playground_verify_limit_' . md5($email);
        $attempts = Cache::get($rateLimitKey, 0);

        if ($attempts >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'Too many verification attempts. Please wait 10 minutes.',
            ], 429);
        }

        Cache::put($rateLimitKey, $attempts + 1, now()->addMinutes(10));

        // Generate a short token
        $token = Str::random(32);

        // Store token in cache for 15 minutes
        $cacheKey = 'playground_verify_' . md5($email);
        Cache::put($cacheKey, [
            'token'    => $token,
            'verified' => false,
        ], now()->addMinutes(15));

        // Build the verification URL
        $verifyUrl = route('playground.confirm-email', [
            'email' => $email,
            'token' => $token,
        ]);

        // Send verification email
        try {
            Mail::to($email)->send(new PlaygroundVerificationMail($email, $verifyUrl));
        } catch (\Exception $e) {
            Log::error('Playground verification email failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification email: ' . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Verification email sent.',
        ]);
    }

    /**
     * Handle the verification link click (from email).
     */
    public function confirmEmail(Request $request)
    {
        $email = strtolower($request->query('email'));
        $token = $request->query('token');

        if (!$email || !$token) {
            abort(400, 'Invalid verification link.');
        }

        $cacheKey = 'playground_verify_' . md5($email);
        $data = Cache::get($cacheKey);

        if (!$data || $data['token'] !== $token) {
            return view('pages.playground-verify-result', [
                'success' => false,
                'message' => 'This verification link is invalid or has expired.',
                'email'   => $email,
            ]);
        }

        // Mark as verified (extend expiry to 60 min from now)
        Cache::put($cacheKey, array_merge($data, ['verified' => true]), now()->addMinutes(60));

        return view('pages.playground-verify-result', [
            'success' => true,
            'message' => 'Your email has been verified! You can now close this tab and submit the form.',
            'email'   => $email,
        ]);
    }

    /**
     * Poll endpoint — JS checks if the email has been verified.
     */
    public function checkVerified(Request $request)
    {
        $email    = strtolower($request->query('email', ''));
        $cacheKey = 'playground_verify_' . md5($email);
        $data     = Cache::get($cacheKey);

        $verified = $data && ($data['verified'] ?? false);

        return response()->json(['verified' => $verified]);
    }

    /**
     * Process the form submission (only allowed for verified emails).
     */
    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string|min:2|max:255',
            'email'           => 'required|email|max:255',
            'message'         => 'required|string|min:5',
            'recipient_email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        // Verify the recipient email was confirmed
        $recipientEmail = strtolower($request->recipient_email);
        $cacheKey = 'playground_verify_' . md5($recipientEmail);
        $data = Cache::get($cacheKey);

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
            ];

            // Collect any extra fields beyond the standard ones
            $standardFields = ['name', 'email', 'message', 'recipient_email', '_token', '_method'];
            $extraFields = [];
            foreach ($request->except($standardFields) as $key => $value) {
                if (!str_starts_with($key, '_')) {
                    $extraFields[$key] = $value;
                }
            }
            $formData['extra_fields'] = $extraFields;

            // Handle file attachments — stored in $fileAttachments to avoid Mailable conflict
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

            Log::info('Playground submission sent', [
                'sender'    => $request->email,
                'recipient' => $recipientEmail,
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Message sent successfully!',
            ]);

        } catch (\Exception $e) {
            Log::error('Playground submission failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => '❌ Failed to send: ' . $e->getMessage(),
            ], 500);
        }
    }
}