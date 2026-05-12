<?php

namespace App\Console\Commands;

use App\Mail\AppointmentReminderMail;
use App\Models\Appointment;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('app:send-appointment-reminders')]
#[Description('Envoie les rappels de rendez-vous J-1 aux clients')]
class SendAppointmentReminders extends Command
{
    public function handle(): int
    {
        $tomorrow = now()->addDay();

        $appointments = Appointment::whereIn('status', ['pending', 'confirmed'])
            ->whereBetween('confirmed_date', [
                $tomorrow->copy()->startOfDay(),
                $tomorrow->copy()->endOfDay(),
            ])
            ->orWhereBetween('requested_date', [
                $tomorrow->copy()->startOfDay(),
                $tomorrow->copy()->endOfDay(),
            ])
            ->get();

        $sent = 0;

        foreach ($appointments as $appointment) {
            Mail::to($appointment->client_email, $appointment->client_name)
                ->send(new AppointmentReminderMail($appointment));
            $sent++;
        }

        $this->info("Rappels envoyés : {$sent}");

        return self::SUCCESS;
    }
}
