<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RecaptchaService
{
    /**
     * Verify reCAPTCHA token
     */
    public function verify(string $token, ?string $ip = null): bool
    {
        // Skip if no token (will be caught by caller)
        if (empty($token)) {
            Log::warning('RecaptchaService: Empty token provided');
            return false;
        }
        
        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $token,
                'remoteip' => $ip ?? request()->ip() ?? '0.0.0.0',
            ]);
            
            if (!$response->successful()) {
                Log::error('RecaptchaService: HTTP request failed', [
                    'status' => $response->status()
                ]);
                return false;
            }
            
            $result = $response->json();
            
            Log::info('RecaptchaService: Verification result', [
                'success' => $result['success'] ?? false,
                'score' => $result['score'] ?? null,
                'action' => $result['action'] ?? null,
                'error_codes' => $result['error-codes'] ?? []
            ]);
            
            return $result['success'] ?? false;
            
        } catch (\Exception $e) {
            Log::error('RecaptchaService: Exception during verification', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Check if captcha is disabled by user via _captcha=false field
     */
    public function isDisabledByUser(array $data): bool
    {
        return isset($data['_captcha']) && $data['_captcha'] === 'false';
    }
}