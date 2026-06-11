<?php

namespace App\Mail;

use App\Models\DiagnosticRequest;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiagnosticRequestedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly DiagnosticRequest $diagnostic) {}

    public function envelope(): Envelope
    {
        $settings = SiteSetting::getAllCached();

        return new Envelope(
            from: new Address(
                $settings->get('contact_email', 'accueil@obsequium-ci.com'),
                $settings->get('brand_name', 'OBSEQUIUM')
            ),
            subject: 'Votre demande de diagnostic gratuit - '.$this->diagnostic->reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.diagnostic-requested',
            with: [
                'diagnostic' => $this->diagnostic,
                'settings' => SiteSetting::getAllCached(),
            ],
        );
    }
}
