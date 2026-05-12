<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Rappels rendez-vous J-1 (tous les jours à 9h)
Schedule::command('app:send-appointment-reminders')->dailyAt('09:00');

// Relances devis sans réponse depuis 7j (tous les jours à 8h)
Schedule::command('app:send-quote-follow-ups')->dailyAt('08:00');
