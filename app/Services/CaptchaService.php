<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CaptchaService
{
    /**
     * Verify a Google reCAPTCHA v2 token.
     * Returns true if valid, false if invalid or missing.
     */
    public function verify(string $token, string $ip = null): bool
    {
        if (empty($token)) {
            Log::warning('Captcha: no token provided');
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => env('CAPTCHA_SECRET_KEY'),
                'response' => $token,
                'remoteip' => $ip,
            ]);

            $result = $response->json();

            Log::info('Captcha verify result', [
                'success'      => $result['success'] ?? false,
                'error-codes'  => $result['error-codes'] ?? [],
            ]);

            return $result['success'] ?? false;

        } catch (\Exception $e) {
            Log::error('Captcha verification failed: ' . $e->getMessage());
            return false;
        }
    }
}