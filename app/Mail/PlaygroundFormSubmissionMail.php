<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlaygroundFormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $formData;
    public array $fileAttachments; // renamed — Mailable already defines $attachments

    public function __construct(array $formData, array $fileAttachments = [])
    {
        $this->formData        = $formData;
        $this->fileAttachments = $fileAttachments;
    }

    public function build(): static
    {
        $email = $this
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($this->formData['sender_email'], $this->formData['name'])
            ->subject('New Form Submission via ' . config('app.name') . ' Playground')
            ->view('emails.playground-submission')
            ->with([
                'formData'    => $this->formData,
                'submittedAt' => now()->format('F j, Y \a\t g:i A T'),
            ]);

        foreach ($this->fileAttachments as $attachment) {
            if (isset($attachment['file']) && file_exists($attachment['file'])) {
                $email->attach($attachment['file'], [
                    'as'   => $attachment['name'] ?? basename($attachment['file']),
                    'mime' => $attachment['mime'] ?? mime_content_type($attachment['file']),
                ]);
            }
        }

        return $email;
    }
}