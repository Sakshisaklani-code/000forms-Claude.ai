<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    public function verify(?string $token): bool
    {
        $secret = config('supabase.recaptcha.secret');

        if (empty($secret)) {
            Log::warning('reCAPTCHA: CAPTCHA_SECRET_KEY not set in .env');
            return true;
        }

        if (empty($token)) {
            Log::warning('reCAPTCHA: No token received');
            return false;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $secret,
                'response' => $token,
            ]);

            $result  = $response->json();
            $success = $result['success'] ?? false;

            Log::info('reCAPTCHA v2 result', ['success' => $success]);

            return $success;

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification exception: ' . $e->getMessage());
            return false;
        }
    }

    public function siteKey(): string
    {
        return config('supabase.recaptcha.site_key', '');
    }
}