<?php

namespace App\Observers;

use App\Mail\DiagnosticRequestedAdminMail;
use App\Models\ActivityLog;
use App\Models\DiagnosticRequest;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;

class DiagnosticRequestObserver
{
    public function created(DiagnosticRequest $diagnostic): void
    {
        $adminEmail = SiteSetting::get('contact_email', config('mail.from.address'));

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new DiagnosticRequestedAdminMail($diagnostic));
        }

        ActivityLog::record('diagnostic.created', "Nouvelle demande de diagnostic #{$diagnostic->reference}", $diagnostic);
    }
}
