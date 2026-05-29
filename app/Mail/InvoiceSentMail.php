<?php

namespace App\Mail;

use App\Models\Invoice;
use App\Models\SiteSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InvoiceSentMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Invoice $invoice,
    ) {}

    public function envelope(): Envelope
    {
        $settings = SiteSetting::getAllCached();

        return new Envelope(
            from: new Address(
                $settings->get('contact_email', 'contact@obsequium-ci.com'),
                $settings->get('brand_name', 'OBSEQUIUM')
            ),
            subject: 'Votre facture '.$this->invoice->reference,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.invoice-sent',
            with: [
                'invoice' => $this->invoice,
                'settings' => SiteSetting::getAllCached(),
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];

        if ($this->invoice->pdf_path && Storage::exists('public/'.$this->invoice->pdf_path)) {
            $attachments[] = Attachment::fromStorageDisk('public', $this->invoice->pdf_path)
                ->as('facture-'.$this->invoice->reference.'.pdf');
        }

        return $attachments;
    }
}
