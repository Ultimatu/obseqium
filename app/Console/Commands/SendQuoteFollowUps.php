<?php

namespace App\Console\Commands;

use App\Mail\QuoteFollowUpMail;
use App\Models\Quote;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('app:send-quote-follow-ups')]
#[Description('Relance les clients dont le devis est sans réponse depuis 7 jours')]
class SendQuoteFollowUps extends Command
{
    public function handle(): int
    {
        $quotes = Quote::whereIn('status', ['sent', 'viewed'])
            ->whereNotNull('sent_at')
            ->where('sent_at', '<=', now()->subDays(7))
            ->whereNull('valid_until')
            ->orWhere(function ($q) {
                $q->whereIn('status', ['sent', 'viewed'])
                    ->whereNotNull('sent_at')
                    ->where('sent_at', '<=', now()->subDays(7))
                    ->where('valid_until', '>=', now());
            })
            ->get();

        $sent = 0;

        foreach ($quotes as $quote) {
            Mail::to($quote->client_email, $quote->client_name)
                ->send(new QuoteFollowUpMail($quote));
            $sent++;
        }

        $this->info("Relances envoyées : {$sent}");

        return self::SUCCESS;
    }
}
