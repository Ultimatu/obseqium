<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteSubmittedAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public readonly Quote $quote) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '['.config('app.name').'] Nouvelle demande de devis - '.$this->quote->client_name,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.admin.quote-submitted');
    }
}
