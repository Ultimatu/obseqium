<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Contacts\ContactResource;
use App\Filament\Resources\FormationRegistrations\FormationRegistrationResource;
use App\Filament\Resources\Newsletters\NewsletterResource;
use App\Filament\Resources\Quotes\QuoteResource;
use App\Models\Appointment;
use App\Models\Contact;
use App\Models\FormationRegistration;
use App\Models\Newsletter;
use App\Models\Quote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $unreadContacts = Contact::where('is_read', false)->count();
        $pendingQuotes = Quote::whereIn('status', ['draft', 'sent', 'viewed'])->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $pendingRegistrations = FormationRegistration::where('status', 'pending')->count();
        $newsletterSubscribers = Newsletter::where('is_active', true)->count();

        return [
            Stat::make('Contacts non lus', $unreadContacts)
                ->description($unreadContacts > 0 ? 'Demandes en attente' : 'Tout est traité')
                ->descriptionIcon($unreadContacts > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($unreadContacts > 0 ? 'warning' : 'success')
                ->chart($this->dailyCount(Contact::class, 'created_at', 7))
                ->chartColor($unreadContacts > 0 ? 'warning' : 'success')
                ->url(ContactResource::getUrl()),

            Stat::make('Devis à traiter', $pendingQuotes)
                ->description('Brouillons, envoyés ou consultés')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($pendingQuotes > 0 ? 'info' : 'success')
                ->chart($this->dailyCount(Quote::class, 'created_at', 7))
                ->chartColor('info')
                ->url(QuoteResource::getUrl()),

            Stat::make('Rendez-vous en attente', $pendingAppointments)
                ->description('À confirmer')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color($pendingAppointments > 0 ? 'primary' : 'gray')
                ->chart($this->dailyCount(Appointment::class, 'created_at', 7))
                ->chartColor('primary')
                ->url(AppointmentResource::getUrl()),

            Stat::make('Inscriptions en attente', $pendingRegistrations)
                ->description('Formations à confirmer')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color($pendingRegistrations > 0 ? 'warning' : 'success')
                ->chart($this->dailyCount(FormationRegistration::class, 'created_at', 7))
                ->chartColor('warning')
                ->url(FormationRegistrationResource::getUrl()),

            Stat::make('Abonnés newsletter', $newsletterSubscribers)
                ->description('Abonnés actifs')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('success')
                ->chart($this->dailyCount(Newsletter::class, 'created_at', 7))
                ->chartColor('success')
                ->url(NewsletterResource::getUrl()),
        ];
    }

    /** @return array<int, int> */
    private function dailyCount(string $model, string $column, int $days): array
    {
        $counts = $model::query()
            ->where($column, '>=', Carbon::now()->subDays($days - 1)->startOfDay())
            ->selectRaw("DATE($column) as date, COUNT(*) as count")
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        return collect(range($days - 1, 0))
            ->map(fn (int $daysAgo) => (int) ($counts[Carbon::now()->subDays($daysAgo)->toDateString()] ?? 0))
            ->values()
            ->all();
    }
}
