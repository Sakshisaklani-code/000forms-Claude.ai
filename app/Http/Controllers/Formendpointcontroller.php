<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Mail\PlaygroundFormSubmissionMail;
use App\Services\CaptchaService;

class FormEndpointController extends Controller
{
    protected CaptchaService $captcha;

    public function __construct(CaptchaService $captcha)
    {
        $this->captcha = $captcha;
    }

    /**
     * POST /f/{email}
     * Accepts form submissions from anywhere (external sites).
     * Requires reCAPTCHA + verified email.
     */
    public function handle(Request $request, string $email)
    {
        $email = strtolower(urldecode($email));

        Log::info('FormEndpoint: received submission', ['email' => $email]);

        // ── 1. Validate email format ─────────────────────────────
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->respond($request, false, 'Invalid endpoint.', 400);
        }

        // ── 2. reCAPTCHA verification ────────────────────────────
        if (!empty(env('CAPTCHA_SITE_KEY'))) {
            $token = $request->input('g-recaptcha-response', '');
            if (!$this->captcha->verify($token, $request->ip())) {
                Log::warning('FormEndpoint: captcha failed', ['email' => $email]);
                return $this->respond($request, false, 'Please complete the CAPTCHA verification.', 422);
            }
        }

        // ── 3. Check email is verified ───────────────────────────
        $cacheKey = 'playground_verify_' . md5($email);
        $cached   = Cache::get($cacheKey);
        $verified = $cached && !empty($cached['verified']);

        // DB fallback
        if (!$verified) {
            try {
                $slug = $this->emailToSlug($email);
                $form = \App\Models\Form::where('slug', $slug)
                    ->orWhere('recipient_email', $email)
                    ->first();
                $verified = $form && $form->email_verified;
            } catch (\Exception $e) {
                Log::warning('FormEndpoint: DB check failed — ' . $e->getMessage());
            }
        }

        if (!$verified) {
            Log::warning('FormEndpoint: email not verified', ['email' => $email]);

            if (!$cached) {
                $this->triggerVerification($email);
                return $this->respond(
                    $request, false,
                    'This email has not been verified. A verification link has been sent to ' . $email,
                    403
                );
            }

            return $this->respond(
                $request, false,
                'Please verify your email first. Check your inbox for the verification link.',
                403
            );
        }

        // ── 4. Honeypot spam check ───────────────────────────────
        if ($request->filled('_honey') || $request->filled('_gotcha')) {
            Log::info('FormEndpoint: honeypot triggered', ['email' => $email]);
            return $this->respond($request, true, 'Thank you!');
        }

        // ── 5. Collect fields ────────────────────────────────────
        $skip   = ['_token', '_method', '_next', '_subject', '_honey', '_gotcha', '_captcha', 'g-recaptcha-response'];
        $fields = [];
        foreach ($request->except($skip) as $key => $value) {
            if (!str_starts_with($key, '_')) {
                $fields[$key] = $value;
            }
        }

        // ── 6. Build email data ──────────────────────────────────
        $standardKeys = ['name', 'full_name', 'first_name', 'email', 'email_address', 'message', 'body'];

        $formData = [
            'name'            => $fields['name']         ?? $fields['full_name']     ?? $fields['first_name'] ?? 'Anonymous',
            'sender_email'    => $fields['email']        ?? $fields['email_address'] ?? 'unknown@unknown.com',
            'message'         => $fields['message']      ?? $fields['body']          ?? json_encode($fields, JSON_PRETTY_PRINT),
            'recipient_email' => $email,
            'submitted_at'    => now()->format('Y-m-d H:i:s'),
            'app_url'         => config('app.url'),
            'extra_fields'    => array_filter(
                $fields,
                fn($k) => !in_array($k, $standardKeys),
                ARRAY_FILTER_USE_KEY
            ),
        ];

        if ($request->filled('_subject')) {
            $formData['extra_fields']['Subject'] = $request->input('_subject');
        }

        // ── 7. Handle file uploads ───────────────────────────────
        $fileAttachments = [];
        foreach ($request->allFiles() as $file) {
            $files = is_array($file) ? $file : [$file];
            foreach ($files as $f) {
                if ($f && $f->isValid()) {
                    $fileAttachments[] = [
                        'file' => $f->path(),
                        'name' => $f->getClientOriginalName(),
                        'mime' => $f->getMimeType(),
                    ];
                }
            }
        }

        // ── 8. Send email ────────────────────────────────────────
        try {
            Mail::to($email)->send(new PlaygroundFormSubmissionMail($formData, $fileAttachments));
            Log::info('FormEndpoint: email sent', ['recipient' => $email]);
        } catch (\Exception $e) {
            Log::error('FormEndpoint: mail failed — ' . $e->getMessage());
            return $this->respond($request, false, 'Failed to send your message. Please try again.', 500);
        }

        return $this->respond($request, true, 'Your message has been sent!');
    }

    protected function respond(Request $request, bool $success, string $message, int $status = 200)
    {
        if ($request->wantsJson() || $request->ajax() || $request->input('_format') === 'json') {
            return response()->json(['success' => $success, 'message' => $message], $status);
        }

        if (!$success) {
            return redirect()->back()->withInput()->with('error', $message);
        }

        $next = $request->input('_next');
        if ($next && filter_var($next, FILTER_VALIDATE_URL)) {
            return redirect()->away($next);
        }

        return redirect()->route('playground.form.submitted')->with('success', $message);
    }

    protected function emailToSlug(string $email): string
    {
        $safe = str_replace(['@', '.'], ['-at-', '-'], $email);
        return 'playground-' . \Illuminate\Support\Str::slug($safe);
    }

    protected function triggerVerification(string $email): void
    {
        try {
            $token    = Str::random(32);
            $cacheKey = 'playground_verify_' . md5($email);
            Cache::put($cacheKey, ['token' => $token, 'verified' => false], now()->addMinutes(15));

            $verifyUrl = route('playground.confirm-email', ['email' => $email, 'token' => $token]);
            Mail::to($email)->send(new \App\Mail\PlaygroundVerificationMail($email, $verifyUrl));
        } catch (\Exception $e) {
            Log::error('FormEndpoint: auto-verification failed — ' . $e->getMessage());
        }
    }
}