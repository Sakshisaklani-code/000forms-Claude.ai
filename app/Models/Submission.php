<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'form_id',
        'data',
        'metadata',
        'ip_address',
        'user_agent',
        'referrer',
        'country',
        'city',
        'is_spam',
        'spam_reason',
        'is_read',
        'read_at',
        'email_sent',
        'email_sent_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'metadata' => 'array',
        'is_spam' => 'boolean',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'email_sent' => 'boolean',
        'email_sent_at' => 'datetime',
    ];

    /**
     * Get the form that owns the submission.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    /**
     * Mark the submission as read.
     */
    public function markAsRead(): void
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    /**
     * Mark the submission as unread.
     */
    public function markAsUnread(): void
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Mark the submission as spam.
     */
    public function markAsSpam(string $reason = 'Manual'): void
    {
        $this->update([
            'is_spam' => true,
            'spam_reason' => $reason,
        ]);
    }

    /**
     * Mark the submission as not spam.
     */
    public function markAsNotSpam(): void
    {
        $this->update([
            'is_spam' => false,
            'spam_reason' => null,
        ]);
    }

    /**
     * Get a summary of the submission data.
     */
    public function getSummaryAttribute(): string
    {
        $data = $this->data;
        
        // Try to find email or name fields
        $email = $data['email'] ?? $data['_replyto'] ?? null;
        $name = $data['name'] ?? $data['full_name'] ?? $data['fullname'] ?? null;
        
        if ($name && $email) {
            return "{$name} <{$email}>";
        } elseif ($email) {
            return $email;
        } elseif ($name) {
            return $name;
        }
        
        // Return first non-empty field
        foreach ($data as $key => $value) {
            if (!str_starts_with($key, '_') && !empty($value) && is_string($value)) {
                return Str::limit($value, 50);
            }
        }
        
        return 'No preview available';
    }

    /**
     * Get subject from metadata or data.
     */
    public function getSubjectAttribute(): ?string
    {
        return $this->metadata['subject'] ?? $this->data['_subject'] ?? $this->data['subject'] ?? null;
    }

    /**
     * Get reply-to email from metadata or data.
     */
    public function getReplyToAttribute(): ?string
    {
        return $this->metadata['replyto'] ?? $this->data['email'] ?? $this->data['_replyto'] ?? null;
    }

    /**
     * Scope for non-spam submissions.
     */
    public function scopeValid($query)
    {
        return $query->where('is_spam', false);
    }

    /**
     * Scope for unread submissions.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for spam submissions.
     */
    public function scopeSpam($query)
    {
        return $query->where('is_spam', true);
    }
}
