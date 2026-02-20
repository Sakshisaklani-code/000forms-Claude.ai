<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PlaygroundFormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $formData;
    public array $fileAttachments;
    public array $specialFields;

    /**
     * Create a new message instance.
     */
    public function __construct(array $formData, array $fileAttachments = [], array $specialFields = [])
    {
        $this->formData = $formData;
        $this->fileAttachments = $fileAttachments;
        $this->specialFields = $specialFields;
    }

    /**
     * Build the message.
     */
    public function build(): static
    {
        // Set subject from _subject field or default
        $subject = $this->specialFields['_subject'] ?? 'New Form Submission from ' . config('app.name');

        // Set reply-to if provided
        if (!empty($this->specialFields['_replyto'])) {
            $this->replyTo($this->specialFields['_replyto']);
        } elseif (!empty($this->formData['sender_email'])) {
            $this->replyTo($this->formData['sender_email']);
        }

        // Add CC if provided
        if (!empty($this->specialFields['_cc'])) {
            $ccEmails = is_array($this->specialFields['_cc']) 
                ? $this->specialFields['_cc'] 
                : array_map('trim', explode(',', $this->specialFields['_cc']));
            
            foreach ($ccEmails as $cc) {
                if (filter_var($cc, FILTER_VALIDATE_EMAIL)) {
                    $this->cc($cc);
                }
            }
        }

        // Add BCC if provided
        if (!empty($this->specialFields['_bcc'])) {
            $bccEmails = is_array($this->specialFields['_bcc']) 
                ? $this->specialFields['_bcc'] 
                : array_map('trim', explode(',', $this->specialFields['_bcc']));
            
            foreach ($bccEmails as $bcc) {
                if (filter_var($bcc, FILTER_VALIDATE_EMAIL)) {
                    $this->bcc($bcc);
                }
            }
        }

        // Add file attachments
        foreach ($this->fileAttachments as $attachment) {
            if (isset($attachment['file']) && file_exists($attachment['file'])) {
                $this->attach($attachment['file'], [
                    'as' => $attachment['name'] ?? 'attachment',
                    'mime' => $attachment['mime'] ?? 'application/octet-stream',
                ]);
            }
        }

        // Determine template
        $template = $this->specialFields['_template'] ?? 'basic';
        
        // Map template to view
        $view = match($template) {
            'table' => 'emails.submission-table',
            'box' => 'emails.submission-box',
            default => 'emails.submission-basic',
        };

        // Prepare data for the view
        $viewData = [
            'formData' => $this->formData,
            'specialFields' => $this->specialFields,
            'appName' => config('app.name'),
            'appUrl' => config('app.url'),
            'submittedAt' => $this->formData['submitted_at'] ?? now()->format('Y-m-d H:i:s'),
            'hasAttachment' => $this->formData['has_attachments'] ?? false,
            'attachmentCount' => $this->formData['attachment_count'] ?? 0,
            'attachments' => $this->formData['attachments_metadata'] ?? [],
            'data' => $this->formData['all_fields'] ?? [],
            'form' => (object)[
                'name' => $this->formData['form_name'] ?? 'Contact Form',
                'slug' => 'playground-form',
                'id' => 0,
            ],
            'submission' => null, // No submission object in playground
        ];

        Log::info('Building form submission email', [
            'subject' => $subject,
            'template' => $template,
            'view' => $view,
            'attachments' => count($this->fileAttachments),
            'has_cc' => !empty($this->specialFields['_cc']),
            'has_bcc' => !empty($this->specialFields['_bcc']),
            'has_replyto' => !empty($this->specialFields['_replyto']) || !empty($this->formData['sender_email'])
        ]);

        return $this
            ->subject($subject)
            ->view($view, $viewData);
    }
}