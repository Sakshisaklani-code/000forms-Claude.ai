<?php

namespace App\Mail;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public Form $form;
    public array $submissionData;
    public ?Submission $submission;
    public ?string $attachmentPath;
    public ?array $attachmentMetadata;
    public string $template;

    /**
     * Create a new message instance.
     */
    public function __construct(
        Form $form,
        array $submissionData,
        ?Submission $submission = null,
        ?string $attachmentPath = null,
        ?array $attachmentMetadata = null
    ) {
        $this->form = $form;
        $this->submissionData = $submissionData;
        $this->submission = $submission;
        $this->attachmentPath = $attachmentPath;
        $this->attachmentMetadata = $attachmentMetadata;
        
        // Determine template: _template parameter, or default to 'basic'
        $this->template = strtolower($submissionData['_template'] ?? 'basic');
        
        // Validate template (only allow: basic, table, box)
        if (!in_array($this->template, ['basic', 'table', 'box'])) {
            $this->template = 'basic';
        }
        
        Log::info('Email template selected: ' . $this->template);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // Get subject from _subject field or use default
        $subject = $this->submissionData['_subject'] ?? 
                   $this->submissionData['subject'] ?? 
                   "New submission from {$this->form->name}";
        
        // Get reply-to from _replyto or email field
        $replyTo = $this->submissionData['_replyto'] ?? 
                   $this->submissionData['email'] ?? 
                   null;
        
        // Build envelope with reply-to if available
        if ($replyTo && filter_var($replyTo, FILTER_VALIDATE_EMAIL)) {
            return new Envelope(
                from: new Address(config('mail.from.address'), $this->form->name),
                replyTo: [new Address($replyTo)],
                subject: $subject,
            );
        }
        
        // Without reply-to
        return new Envelope(
            from: new Address(config('mail.from.address'), $this->form->name),
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // Select the appropriate view based on template
        $viewName = match($this->template) {
            'table' => 'emails.submission-table',
            'box' => 'emails.submission-box',
            default => 'emails.submission-basic',
        };
        
        return new Content(
            view: $viewName,
            with: [
                'form' => $this->form,
                'data' => $this->getCleanedData(),
                'submission' => $this->submission,
                'hasAttachment' => $this->attachmentPath !== null,
                'attachmentName' => $this->attachmentMetadata['name'] ?? null,
                'attachmentSize' => $this->formatFileSize($this->attachmentMetadata['size'] ?? 0),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            Log::info('Attaching file: ' . $this->attachmentPath);
            
            $attachments[] = Attachment::fromPath($this->attachmentPath)
                ->as($this->attachmentMetadata['name'] ?? 'attachment')
                ->withMime($this->attachmentMetadata['type'] ?? 'application/octet-stream');
        }
        
        return $attachments;
    }

    /**
     * Get cleaned data without internal fields
     */
    protected function getCleanedData(): array
    {
        $cleaned = [];
        
        foreach ($this->submissionData as $key => $value) {
            // Skip internal fields and upload metadata
            if (str_starts_with($key, '_') || $key === 'upload') {
                continue;
            }
            
            // Skip arrays (like upload metadata)
            if (is_array($value)) {
                continue;
            }
            
            $cleaned[$key] = $value;
        }
        
        return $cleaned;
    }

    /**
     * Format file size to human-readable format
     */
    protected function formatFileSize(int $bytes): string
    {
        if ($bytes === 0) {
            return '0 B';
        }
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes, 1024));
        
        return round($bytes / pow(1024, $i), 2) . ' ' . $units[$i];
    }
}