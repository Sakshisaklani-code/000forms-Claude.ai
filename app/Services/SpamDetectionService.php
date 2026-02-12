<?php

namespace App\Services;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SpamDetectionService
{
    /**
     * Check if a submission is spam.
     */
    public function isSpam(Form $form, Request $request, array $data): array
    {
        $reasons = [];

        // Check honeypot field
        if ($form->honeypot_enabled) {
            $honeypotValue = $data[$form->honeypot_field] ?? null;
            if (!empty($honeypotValue)) {
                $reasons[] = 'Honeypot field filled';
            }
        }

        // Check for too-fast submission (less than 3 seconds)
        $formLoadTime = $data['_form_load_time'] ?? null;
        if ($formLoadTime) {
            $submissionTime = time();
            if (($submissionTime - (int)$formLoadTime) < 3) {
                $reasons[] = 'Submission too fast';
            }
        }

        // Check rate limiting by IP
        $ip = $request->ip();
        $rateLimitKey = "spam_check:{$form->id}:{$ip}";
        $submissionCount = Cache::get($rateLimitKey, 0);
        
        if ($submissionCount >= 5) {
            $reasons[] = 'Rate limit exceeded';
        } else {
            Cache::put($rateLimitKey, $submissionCount + 1, now()->addMinutes(10));
        }

        // Check for spam keywords
        $spamKeywords = [
            'viagra', 'cialis', 'casino', 'lottery', 'winner',
            'cryptocurrency', 'bitcoin profit', 'make money fast',
            'click here', 'act now', 'limited time', 'free money',
        ];

        $contentToCheck = strtolower(implode(' ', array_values(
            array_filter($data, fn($v) => is_string($v))
        )));

        foreach ($spamKeywords as $keyword) {
            if (str_contains($contentToCheck, $keyword)) {
                $reasons[] = "Spam keyword: {$keyword}";
                break;
            }
        }

        // Check for too many URLs
        $urlCount = preg_match_all('/https?:\/\/[^\s]+/', $contentToCheck);
        if ($urlCount > 3) {
            $reasons[] = 'Too many URLs';
        }

        // Check for repetitive content
        if ($this->hasRepetitiveContent($contentToCheck)) {
            $reasons[] = 'Repetitive content';
        }

        // Check for blocked IP (future: could be user-configured)
        if ($this->isBlockedIp($ip)) {
            $reasons[] = 'Blocked IP address';
        }

        return [
            'is_spam' => !empty($reasons),
            'reasons' => $reasons,
        ];
    }

    /**
     * Check for repetitive content patterns.
     */
    protected function hasRepetitiveContent(string $content): bool
    {
        // Check for same word repeated too many times
        $words = str_word_count($content, 1);
        $wordCounts = array_count_values($words);
        
        foreach ($wordCounts as $word => $count) {
            if (strlen($word) > 3 && $count > 10) {
                return true;
            }
        }

        // Check for same character repeated
        if (preg_match('/(.)\1{20,}/', $content)) {
            return true;
        }

        return false;
    }

    /**
     * Check if IP is in blocklist.
     */
    protected function isBlockedIp(string $ip): bool
    {
        // Could be expanded to check against a database table
        $blockedIps = Cache::get('blocked_ips', []);
        return in_array($ip, $blockedIps);
    }

    /**
     * Add IP to blocklist.
     */
    public function blockIp(string $ip, int $hours = 24): void
    {
        $blockedIps = Cache::get('blocked_ips', []);
        $blockedIps[] = $ip;
        Cache::put('blocked_ips', array_unique($blockedIps), now()->addHours($hours));
    }

    /**
     * Remove IP from blocklist.
     */
    public function unblockIp(string $ip): void
    {
        $blockedIps = Cache::get('blocked_ips', []);
        $blockedIps = array_diff($blockedIps, [$ip]);
        Cache::put('blocked_ips', $blockedIps, now()->addDay());
    }
}
