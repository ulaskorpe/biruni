<?php

namespace App\Mail;

use App\Models\User;
use App\Models\EmailContent;
use App\Models\Form;
use App\Models\FormEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\View;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneralFormMail extends Mailable
{
    use Queueable, SerializesModels;

    protected Form $form;
    protected FormEntry $entry;
    
    public function __construct($form,$entry)
    {
        $this->form = $form;
        $this->entry = $entry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->form->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'emails.general-form-layout',
            with: [
                'form' => $this->form,
                'entry' => $this->entry,
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
