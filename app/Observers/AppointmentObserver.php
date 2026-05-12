<?php

namespace App\Observers;

use App\Mail\AppointmentBookedMail;
use App\Mail\AppointmentConfirmationMail;
use App\Models\ActivityLog;
use App\Models\Appointment;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Mail;

class AppointmentObserver
{
    public function created(Appointment $appointment): void
    {
        $adminEmail = SiteSetting::get('contact_email', config('mail.from.address'));

        if ($adminEmail) {
            Mail::to($adminEmail)->send(new AppointmentBookedMail($appointment));
        }

        Mail::to($appointment->client_email, $appointment->client_name)
            ->send(new AppointmentConfirmationMail($appointment));

        ActivityLog::record('appointment.created', "Nouveau rendez-vous demandé par {$appointment->client_name}", $appointment);
    }
}
