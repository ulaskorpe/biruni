<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailContent;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;

class NewMemberMail extends Mailable
{
    use Queueable, SerializesModels;

    protected User $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Üyelik başvurunuz alındı!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $email_content = EmailContent::where('use_for','register')->first();

        return new Content(
            view: 'emails.dynamic-email-layout',
            with: [
                'user' => $this->user,
                'email_content' => $email_content,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
