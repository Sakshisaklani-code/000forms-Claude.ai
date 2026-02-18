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