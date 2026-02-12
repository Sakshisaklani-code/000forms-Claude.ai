<?php
// app/Models/Form.php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'recipient_email',
        'cc_emails',
        'blacklist_phrases',
        'email_verified',
        'email_verification_token',
        'email_verified_at',
        'allow_file_upload',
        'status',
        'redirect_url',
        'success_message',
        'auto_response_enabled',
        'auto_response_message',
        'honeypot_enabled',
        'honeypot_field',
        'email_notifications',
        'store_submissions',
        'submission_count',
        'spam_count',
        'last_submission_at',
        'allowed_domains',
        'metadata',
    ];

    protected $casts = [
        'email_verified' => 'boolean',
        'email_verified_at' => 'datetime',
        'honeypot_enabled' => 'boolean',
        'email_notifications' => 'boolean',
        'store_submissions' => 'boolean',
        'last_submission_at' => 'datetime',
        'auto_response_enabled' => 'boolean',
        'allowed_domains' => 'array',
        'metadata' => 'array',
        'cc_emails' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($form) {
            if (empty($form->slug)) {
                $form->slug = self::generateUniqueSlug();
            }
            if (empty($form->email_verification_token)) {
                $form->email_verification_token = Str::random(64);
            }
            if (empty($form->honeypot_field)) {
                $form->honeypot_field = 'honeypot_' . Str::random(8);
            }
            if (empty($form->success_message)) {
                $form->success_message = 'Thank you for your submission!';
            }
        });
    }

    public static function generateUniqueSlug(): string
    {
        do {
            $slug = 'f_' . Str::lower(Str::random(8));
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function validSubmissions()
    {
        return $this->submissions()->where('is_spam', false);
    }

    public function getUnreadCountAttribute(): int
    {
        return $this->submissions()
            ->where('is_spam', false)
            ->where('is_read', false)
            ->count();
    }

    public function getEndpointUrlAttribute(): string
    {
        return route('form.submit', ['slug' => $this->slug]);
    }

    public function getVerificationUrlAttribute(): string
    {
        return route('verify.email', ['token' => $this->email_verification_token]);
    }

    public function canAcceptSubmissions(): bool
    {
        return $this->status === 'active' && $this->email_verified;
    }

    public function isDomainAllowed(?string $referer): bool
    {
        if (empty($this->allowed_domains)) {
            return true;
        }

        if (empty($referer)) {
            return false;
        }

        $refererHost = parse_url($referer, PHP_URL_HOST);
        
        foreach ($this->allowed_domains as $domain) {
            if ($refererHost === $domain || Str::endsWith($refererHost, '.' . $domain)) {
                return true;
            }
        }

        return false;
    }

    public function incrementSubmissionCount(bool $isSpam = false): void
    {
        if ($isSpam) {
            $this->increment('spam_count');
        } else {
            $this->increment('submission_count');
        }
        
        $this->update(['last_submission_at' => now()]);
    }

    /**
     * Get the CC email
     */
    public function getCcEmailsArrayAttribute(): array
    {
        if (empty($this->cc_emails)) {
            return [];
        }
        
        if (is_string($this->cc_emails)) {
            $emails = array_map('trim', explode(',', $this->cc_emails));
            return array_filter($emails, fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
        }
        
        return array_filter($this->cc_emails, fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL));
    }

    public function getVisitorEmail(array $submissionData): ?string
    {
        $possibleEmailFields = ['email', 'e-mail', 'mail', 'contact_email', 'sender_email', '_replyto'];
        
        foreach ($possibleEmailFields as $field) {
            if (!empty($submissionData[$field]) && filter_var($submissionData[$field], FILTER_VALIDATE_EMAIL)) {
                return $submissionData[$field];
            }
        }
        
        return null;
    }

    /**
     * Get the visitor's name from submission data
     */
    public function getVisitorName(array $submissionData): ?string
    {
        $possibleNameFields = ['name', 'full_name', 'fullname', 'sender_name', 'contact_name'];
        
        foreach ($possibleNameFields as $field) {
            if (!empty($submissionData[$field]) && is_string($submissionData[$field])) {
                return $submissionData[$field];
            }
        }
        
        return null;
    }

    /**
     * Parse auto-response message with placeholders
     */
    public function parseAutoResponseMessage(string $message, array $submissionData): string
    {
        $replacements = [
            '{form_name}' => $this->name,
            '{submission_date}' => now()->format('F j, Y'),
            '{submission_time}' => now()->format('g:i A'),
            '{visitor_name}' => $this->getVisitorName($submissionData) ?? 'Valued Customer',
            '{visitor_email}' => $this->getVisitorEmail($submissionData) ?? '',
            '{site_name}' => config('app.name'),
        ];

        // Add dynamic field replacements
        foreach ($submissionData as $key => $value) {
            if (!str_starts_with($key, '_') && !is_array($value)) {
                $replacements['{' . $key . '}'] = $value;
            }
        }

        return str_replace(array_keys($replacements), array_values($replacements), $message);
    }

}