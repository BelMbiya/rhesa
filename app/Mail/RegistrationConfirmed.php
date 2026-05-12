<?php

namespace App\Mail;

use App\Models\Registration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    // ✅ Plus de $pdfContent
    public function __construct(public Registration $registration) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de votre enregistrement à '
                . $this->registration->stay->hotel->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.registration.confirmed',
        );
    }

    // ✅ Aucune pièce jointe
    public function attachments(): array
    {
        return [];
    }
}