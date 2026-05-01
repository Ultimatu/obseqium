<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Contact;
use App\Models\FormationRegistration;
use App\Models\Quote;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class ActivityChartWidget extends ChartWidget
{
    protected  ?string $heading = 'Activité des 30 derniers jours';

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected  ?string $maxHeight = '260px';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $days = 30;
        $labels = [];
        $contacts = [];
        $quotes = [];
        $appointments = [];
        $registrations = [];

        $since = Carbon::now()->subDays($days - 1)->startOfDay();

        $contactCounts = Contact::query()
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $quoteCounts = Quote::query()
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $appointmentCounts = Appointment::query()
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        $registrationCounts = FormationRegistration::query()
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $labels[] = Carbon::now()->subDays($i)->format('d/m');
            $contacts[] = (int) ($contactCounts[$date] ?? 0);
            $quotes[] = (int) ($quoteCounts[$date] ?? 0);
            $appointments[] = (int) ($appointmentCounts[$date] ?? 0);
            $registrations[] = (int) ($registrationCounts[$date] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Contacts',
                    'data' => $contacts,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.08)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 2,
                ],
                [
                    'label' => 'Devis',
                    'data' => $quotes,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.08)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 2,
                ],
                [
                    'label' => 'Rendez-vous',
                    'data' => $appointments,
                    'borderColor' => '#1a7a4a',
                    'backgroundColor' => 'rgba(26, 122, 74, 0.08)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 2,
                ],
                [
                    'label' => 'Inscriptions',
                    'data' => $registrations,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.08)',
                    'fill' => true,
                    'tension' => 0.4,
                    'pointRadius' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => true, 'position' => 'top'],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['stepSize' => 1, 'precision' => 0],
                ],
            ],
        ];
    }
}
