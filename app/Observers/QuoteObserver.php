<?php

namespace App\Observers;

use App\Mail\QuoteSubmittedAdminMail;
use App\Models\ActivityLog;
use App\Models\Quote;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;

class QuoteObserver
{
    public function created(Quote $quote): void
    {
        $adminEmail = SiteSetting::get('contact_email', config('mail.from.address'));

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new QuoteSubmittedAdminMail($quote));
        }

        ActivityLog::record('quote.created', "Nouvelle demande de devis #{$quote->reference}", $quote);
    }

    public function updated(Quote $quote): void
    {
        if ($quote->isDirty('status')) {
            ActivityLog::record(
                'quote.status_changed',
                "Devis #{$quote->reference} : statut changé en « {$quote->status} »",
                $quote,
                ['old_status' => $quote->getOriginal('status'), 'new_status' => $quote->status],
            );
        }
    }
}
