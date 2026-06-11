<?php

namespace App\Observers;

use App\Mail\ContactSubmittedMail;
use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\SiteSetting;
use App\Models\User;
use App\Notifications\AdminActionNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ContactObserver
{
    public function created(Contact $contact): void
    {
        $adminEmail = SiteSetting::get('contact_email', config('mail.from.address'));

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactSubmittedMail($contact));
        }

        ActivityLog::record('contact.created', "Nouvelle demande de contact de {$contact->name}", $contact);

        Notification::send(
            User::get(),
            new AdminActionNotification(
                title: 'Nouveau message de contact',
                body: $contact->name.($contact->subject ? ' - '.$contact->subject : ''),
                url: url('/admin/contacts'),
                icon: 'heroicon-o-envelope',
                color: 'warning',
            )
        );
    }
}
