<?php

namespace App\Mail;

use App\Models\DiagnosticRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DiagnosticRequestedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly DiagnosticRequest $diagnostic) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '['.config('app.name').'] Nouvelle demande de diagnostic - '.$this->diagnostic->reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.diagnostic-requested',
            with: ['diagnostic' => $this->diagnostic],
        );
    }
}
