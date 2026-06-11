<?php

namespace App\Mail;

use App\Models\FormationRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AttestationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly FormationRegistration $registration) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre attestation de formation - '.$this->registration->session->formation->title,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.attestation');
    }

    public function attachments(): array
    {
        if (! $this->registration->attestation_path) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('public', $this->registration->attestation_path)
                ->as('attestation-'.$this->registration->session->formation->slug.'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
