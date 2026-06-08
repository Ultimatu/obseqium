<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\FormationRegistration;
use App\Models\Newsletter;
use App\Models\Quote;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $unreadContacts = Contact::where('is_read', false)->count();
        $pendingQuotes = Quote::whereIn('status', ['draft', 'sent', 'viewed'])->count();
        $upcomingAppointments = Appointment::whereIn('status', ['pending', 'confirmed'])
            ->where('requested_date', '>=', now())
            ->count();
        $pendingRegistrations = FormationRegistration::where('status', 'pending')->count();
        $newsletterSubscribers = Newsletter::where('is_active', true)->count();

        return [
            Stat::make('Contacts non lus', $unreadContacts)
                ->description('Demandes en attente de traitement')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unreadContacts > 0 ? 'warning' : 'success'),

            Stat::make('Devis à traiter', $pendingQuotes)
                ->description('Brouillons, envoyés ou consultés')
                ->descriptionIcon('heroicon-m-document-text')
                ->color($pendingQuotes > 0 ? 'info' : 'success'),

            Stat::make('Rendez-vous à venir', $upcomingAppointments)
                ->description('En attente ou confirmés')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color($upcomingAppointments > 0 ? 'primary' : 'gray'),

            Stat::make('Inscriptions en attente', $pendingRegistrations)
                ->description('Formations à confirmer')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color($pendingRegistrations > 0 ? 'warning' : 'success'),

            Stat::make('Abonnés newsletter', $newsletterSubscribers)
                ->description('Abonnés actifs')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('success'),
        ];
    }
}
