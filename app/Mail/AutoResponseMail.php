<?php

namespace App\Mail;

use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class AutoResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public Form $form;
    public array $data;
    public string $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct(Form $form, array $data, string $messageContent)
    {
        $this->form = $form;
        $this->data = $data;
        $this->messageContent = $messageContent;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name', '000form')),
            replyTo: [new Address($this->form->recipient_email)],
            subject: 'Thank you for contacting us',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.auto-response',
            with: [
                'form' => $this->form,
                'data' => $this->data,
                'messageContent' => $this->messageContent, // Pass as 'messageContent' to avoid conflict
            ],
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}