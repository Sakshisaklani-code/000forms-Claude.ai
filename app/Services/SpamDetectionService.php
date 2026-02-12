<?php

namespace App\Services;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

        // Check _gotcha field (alternative honeypot)
        if (!empty($data['_gotcha'])) {
            $reasons[] = 'Gotcha field filled';
        }

        // Check for too-fast submission (less than 3 seconds)
        $formLoadTime = $data['_form_load_time'] ?? null;
        if ($formLoadTime) {
            $submissionTime = time();
            $timeDiff = $submissionTime - (int)$formLoadTime;
            if ($timeDiff < 3) {
                $reasons[] = "Submission too fast ({$timeDiff}s)";
                Log::info('Submission too fast', ['time_diff' => $timeDiff]);
            }
        }

        // Check rate limiting by IP
        $ip = $request->ip();
        $rateLimitKey = "spam_check:{$form->id}:{$ip}";
        $submissionCount = Cache::get($rateLimitKey, 0);
        
        if ($submissionCount >= 5) {
            $reasons[] = 'Rate limit exceeded';
            Log::info('Rate limit exceeded', ['ip' => $ip, 'count' => $submissionCount]);
        } else {
            Cache::put($rateLimitKey, $submissionCount + 1, now()->addMinutes(10));
        }

        // CRITICAL FIX: Only check blacklist if it exists and has content
        if (!empty($data['_blacklist']) && is_string($data['_blacklist'])) {
            Log::info('Checking _blacklist field', [
                'blacklist_length' => strlen($data['_blacklist']),
                'preview' => substr($data['_blacklist'], 0, 100),
            ]);
            
            $blacklistCheck = $this->checkBlacklist($data, $data['_blacklist']);
            if ($blacklistCheck['is_spam']) {
                $reasons = array_merge($reasons, $blacklistCheck['reasons']);
                
                Log::warning('BLACKLIST TRIGGERED', [
                    'form_id' => $form->id,
                    'ip' => $ip,
                    'matched_phrases' => $blacklistCheck['reasons'],
                ]);
            }
        }

        // Check form-level blacklist (if stored in form settings)
        if (!empty($form->blacklist_phrases) && is_string($form->blacklist_phrases)) {
            Log::info('Checking form-level blacklist', [
                'blacklist_length' => strlen($form->blacklist_phrases),
            ]);
            
            $blacklistCheck = $this->checkBlacklist($data, $form->blacklist_phrases);
            if ($blacklistCheck['is_spam']) {
                $reasons = array_merge($reasons, $blacklistCheck['reasons']);
                
                Log::warning('FORM BLACKLIST TRIGGERED', [
                    'form_id' => $form->id,
                    'ip' => $ip,
                    'matched_phrases' => $blacklistCheck['reasons'],
                ]);
            }
        }

        // Check for spam keywords
        $spamKeywords = [
            'viagra', 'cialis', 'casino', 'lottery', 'winner',
            'cryptocurrency', 'bitcoin profit', 'make money fast',
            'click here', 'act now', 'limited time', 'free money',
        ];

        // Build content to check, excluding ALL internal fields
        $contentParts = [];
        foreach ($data as $key => $value) {
            // Skip internal fields (starting with _) and file uploads
            if (str_starts_with($key, '_') || is_array($value) || $key === $form->honeypot_field) {
                continue;
            }
            if (is_string($value)) {
                $contentParts[] = $value;
            }
        }
        $contentToCheck = strtolower(implode(' ', $contentParts));

        foreach ($spamKeywords as $keyword) {
            if (str_contains($contentToCheck, $keyword)) {
                $reasons[] = "Spam keyword: {$keyword}";
                Log::info('Spam keyword detected', ['keyword' => $keyword]);
                break;
            }
        }

        // Check for too many URLs
        $urlCount = preg_match_all('/https?:\/\/[^\s]+/', $contentToCheck);
        if ($urlCount > 3) {
            $reasons[] = 'Too many URLs';
            Log::info('Too many URLs', ['count' => $urlCount]);
        }

        // Check for repetitive content
        if ($this->hasRepetitiveContent($contentToCheck)) {
            $reasons[] = 'Repetitive content';
            Log::info('Repetitive content detected');
        }

        // Check for blocked IP
        if ($this->isBlockedIp($ip)) {
            $reasons[] = 'Blocked IP address';
            Log::info('Blocked IP', ['ip' => $ip]);
        }

        // Final spam check result
        $isSpam = !empty($reasons);
        
        Log::info($isSpam ? 'MARKED AS SPAM' : 'VALID SUBMISSION', [
            'form_id' => $form->id,
            'ip' => $ip,
            'is_spam' => $isSpam,
            'reasons' => $reasons,
        ]);

        return [
            'is_spam' => $isSpam,
            'reasons' => $reasons,
        ];
    }

    /**
     * FIXED: Check if submission contains blacklisted phrases.
     * 
     * @param array $data - The form submission data
     * @param string $blacklist - Comma or newline separated list of phrases
     * @return array ['is_spam' => bool, 'reasons' => array]
     */
    protected function checkBlacklist(array $data, string $blacklist): array
    {
        $reasons = [];
        
        // Parse blacklist - support both comma and newline separation
        $phrases = array_map('trim', preg_split('/[,\n\r]+/', $blacklist));
        $phrases = array_filter($phrases, function($phrase) {
            return !empty($phrase) && strlen($phrase) > 0;
        });
        
        if (empty($phrases)) {
            Log::info('ℹ️ No valid blacklist phrases found');
            return ['is_spam' => false, 'reasons' => []];
        }
        
        Log::info('Blacklist check started', [
            'phrases_count' => count($phrases),
            'phrases' => $phrases,
        ]);
        
        // CRITICAL FIX: Only check actual form fields, not internal fields
        foreach ($data as $key => $value) {
            // Skip ALL internal fields (starting with _)
            // This is THE KEY FIX - prevents _blacklist from matching against itself!
            if (str_starts_with($key, '_')) {
                Log::debug('⏭️ Skipping internal field', ['field' => $key]);
                continue;
            }
            
            // Skip non-string values (arrays, objects, etc.)
            if (!is_string($value)) {
                Log::debug('Skipping non-string field', ['field' => $key, 'type' => gettype($value)]);
                continue;
            }
            
            // Skip empty values
            if (empty(trim($value))) {
                Log::debug('Skipping empty field', ['field' => $key]);
                continue;
            }
            
            // Convert to lowercase for case-insensitive matching
            $valueLower = mb_strtolower($value);
            
            Log::debug('Checking field against blacklist', [
                'field' => $key,
                'value_length' => strlen($value),
                'value_preview' => mb_substr($value, 0, 50),
            ]);
            
            foreach ($phrases as $phrase) {
                $phraseLower = mb_strtolower(trim($phrase));
                
                // Check if phrase exists in value (case-insensitive, partial match)
                if (mb_strpos($valueLower, $phraseLower) !== false) {
                    $reasons[] = "Blacklisted phrase: '{$phrase}' found in '{$key}'";
                    
                    Log::warning('BLACKLIST MATCH!', [
                        'field' => $key,
                        'phrase' => $phrase,
                        'value_preview' => mb_substr($value, 0, 100) . '...',
                    ]);
                    
                    // Break inner loop - one match per field is enough
                    break;
                }
            }
        }
        
        if (empty($reasons)) {
            Log::info('No blacklist matches found');
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
        if (empty($content)) {
            return false;
        }
        
        // Check for same word repeated too many times
        $words = str_word_count($content, 1);
        if (empty($words)) {
            return false;
        }
        
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
        
        Log::info('IP blocked', ['ip' => $ip, 'hours' => $hours]);
    }

    /**
     * Remove IP from blocklist.
     */
    public function unblockIp(string $ip): void
    {
        $blockedIps = Cache::get('blocked_ips', []);
        $blockedIps = array_diff($blockedIps, [$ip]);
        Cache::put('blocked_ips', $blockedIps, now()->addDay());
        
        Log::info('IP unblocked', ['ip' => $ip]);
    }
}