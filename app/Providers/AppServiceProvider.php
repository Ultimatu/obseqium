<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\Quote;
use App\Models\SiteSetting;
use App\Observers\AppointmentObserver;
use App\Observers\ContactObserver;
use App\Observers\QuoteObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('siteSettings', SiteSetting::getAllCached());
        });

        Contact::observe(ContactObserver::class);
        Appointment::observe(AppointmentObserver::class);
        Quote::observe(QuoteObserver::class);
    }
}
