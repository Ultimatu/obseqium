<?php

namespace App\Observers;

use App\Mail\ContactSubmittedMail;
use App\Models\ActivityLog;
use App\Models\Contact;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;

class ContactObserver
{
    public function created(Contact $contact): void
    {
        $adminEmail = SiteSetting::get('contact_email', config('mail.from.address'));

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new ContactSubmittedMail($contact));
        }

        ActivityLog::record('contact.created', "Nouvelle demande de contact de {$contact->name}", $contact);
    }
}
