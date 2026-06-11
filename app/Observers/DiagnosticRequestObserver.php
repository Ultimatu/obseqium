<?php

namespace App\Observers;

use App\Mail\DiagnosticRequestedAdminMail;
use App\Models\ActivityLog;
use App\Models\DiagnosticRequest;
use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\AdminActionNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class DiagnosticRequestObserver
{
    public function created(DiagnosticRequest $diagnostic): void
    {
        $adminEmail = SiteSetting::get('contact_email', config('mail.from.address'));

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new DiagnosticRequestedAdminMail($diagnostic));
        }

        ActivityLog::record('diagnostic.created', "Nouvelle demande de diagnostic #{$diagnostic->reference}", $diagnostic);

        Notification::send(
            User::get(),
            new AdminActionNotification(
                title: 'Nouveau diagnostic - '.$diagnostic->reference,
                body: $diagnostic->client_name.($diagnostic->client_company ? ' ('.$diagnostic->client_company.')' : ''),
                url: url('/admin/diagnostic-requests'),
                icon: 'heroicon-o-clipboard-document-check',
                color: 'warning',
            )
        );
    }
}
