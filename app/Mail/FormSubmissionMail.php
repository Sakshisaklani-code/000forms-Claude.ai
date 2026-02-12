<?php

namespace App\Mail;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FormSubmissionMail extends Mailable
{
    use Queueable, SerializesModels;

    public Form $form;
    public array $data;
    public ?Submission $submission;
    public ?string $attachmentPath;
    public ?array $attachmentMetadata;

    /**
     * Create a new message instance.
     *
     * @param Form $form
     * @param array $data
     * @param Submission|null $submission
     * @param string|null $attachmentPath - Absolute path to the uploaded file
     * @param array|null $attachmentMetadata - Metadata about the file (name, type, size)
     */
    public function __construct(
        Form $form, 
        array $data, 
        ?Submission $submission = null,
        ?string $attachmentPath = null,
        ?array $attachmentMetadata = null
    ) {
        $this->form = $form;
        $this->data = $data;
        $this->submission = $submission;
        $this->attachmentPath = $attachmentPath;
        $this->attachmentMetadata = $attachmentMetadata;
    }

    public function envelope(): Envelope
    {
        $subject = $this->data['_subject'] 
            ?? "New submission: {$this->form->name}";

        $replyTo = null;
        if (!empty($this->data['_replyto'])) {
            $replyTo = new Address($this->data['_replyto']);
        } elseif (!empty($this->data['email']) && filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $replyTo = new Address($this->data['email'], $this->data['name'] ?? null);
        }

        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name', '000form')),
            replyTo: $replyTo ? [$replyTo] : [],
            subject: $subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.submission',
            with: [
                'form' => $this->form,
                'data' => $this->data,
                'submission' => $this->submission,
                'hasAttachment' => $this->attachmentPath !== null,
                'attachmentPath' => $this->attachmentPath, // Pass path to view for embedding
                'attachmentMetadata' => $this->attachmentMetadata,
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        Log::info('========== ATTACHMENT DEBUG START ==========');
        Log::info('Form ID: ' . $this->form->id);
        Log::info('Attachment path provided: ' . ($this->attachmentPath ? 'YES' : 'NO'));
        
        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            try {
                $fileName = $this->attachmentMetadata['name'] ?? basename($this->attachmentPath);
                $mimeType = $this->attachmentMetadata['type'] ?? 'application/octet-stream';
                $isImage = str_starts_with($mimeType, 'image/');
                
                Log::info('✅ Processing file', [
                    'path' => $this->attachmentPath,
                    'name' => $fileName,
                    'type' => $mimeType,
                    'is_image' => $isImage,
                    'size' => filesize($this->attachmentPath) . ' bytes',
                ]);
                
                // ALWAYS attach the file - whether image or not
                // Images will be both attached AND embedded in the email body
                $attachments[] = Attachment::fromPath($this->attachmentPath)
                    ->as($fileName)
                    ->withMime($mimeType);
                
                Log::info('✅ FILE ATTACHED: ' . $fileName . ($isImage ? ' (will also be embedded inline)' : ''));
                
            } catch (\Exception $e) {
                Log::error('❌ Failed to attach file: ' . $e->getMessage());
                Log::error('Stack trace: ' . $e->getTraceAsString());
            }
        } else {
            if ($this->attachmentPath) {
                Log::error('❌ File does not exist at path: ' . $this->attachmentPath);
            } else {
                Log::info('ℹ️ No attachment to include');
            }
        }
        
        Log::info('Total attachments: ' . count($attachments));
        Log::info('========== ATTACHMENT DEBUG END ==========');
        
        return $attachments;
    }
}