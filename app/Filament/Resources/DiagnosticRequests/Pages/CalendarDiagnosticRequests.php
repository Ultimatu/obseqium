<?php

namespace App\Filament\Resources\DiagnosticRequests\Pages;

use App\Filament\Resources\DiagnosticRequests\DiagnosticRequestResource;
use App\Models\DiagnosticRequest;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Support\Icons\Heroicon;

class CalendarDiagnosticRequests extends Page
{
    protected static string $resource = DiagnosticRequestResource::class;

    protected string $view = 'filament.resources.diagnostic-requests.pages.calendar';

    protected static ?string $title = 'Calendrier des diagnostics';

    protected static ?string $navigationLabel = 'Calendrier';

    public int $year = 0;

    public int $month = 0;

    public function mount(): void
    {
        $now = Carbon::now();
        $this->year = $now->year;
        $this->month = $now->month;
    }

    public function prevMonth(): void
    {
        $target = Carbon::create($this->year, $this->month, 1)->subMonth();
        $this->year = $target->year;
        $this->month = $target->month;
    }

    public function nextMonth(): void
    {
        $target = Carbon::create($this->year, $this->month, 1)->addMonth();
        $this->year = $target->year;
        $this->month = $target->month;
    }

    public function today(): void
    {
        $now = Carbon::now();
        $this->year = $now->year;
        $this->month = $now->month;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('today')
                ->label("Aujourd'hui")
                ->icon(Heroicon::OutlinedCalendarDays)
                ->color('gray')
                ->action('today'),
            Action::make('list')
                ->label('Vue liste')
                ->icon(Heroicon::OutlinedListBullet)
                ->color('gray')
                ->url(DiagnosticRequestResource::getUrl('index')),
        ];
    }

    /**
     * @return array<int, array<string, mixed>|null>
     */
    public function getCalendarDays(): array
    {
        $firstDay = Carbon::create($this->year, $this->month, 1);
        $daysInMonth = $firstDay->daysInMonth;
        // Mon=0…Sun=6
        $startDow = ($firstDay->dayOfWeek + 6) % 7;
        $today = Carbon::today();

        $start = $firstDay->copy()->startOfDay();
        $end = $firstDay->copy()->endOfMonth()->endOfDay();

        $diagnostics = DiagnosticRequest::query()
            ->with('consultant')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('scheduled_date', [$start, $end])
                    ->orWhere(function ($q2) use ($start, $end) {
                        $q2->whereNull('scheduled_date')
                            ->whereBetween('requested_date', [$start, $end]);
                    });
            })
            ->get()
            ->groupBy(function (DiagnosticRequest $d) {
                $date = $d->scheduled_date ?? $d->requested_date;

                return $date ? Carbon::parse($date)->format('Y-m-d') : null;
            });

        $days = [];
        for ($i = 0; $i < $startDow; $i++) {
            $days[] = null;
        }

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($this->year, $this->month, $d);
            $key = $date->format('Y-m-d');
            $days[] = [
                'day' => $d,
                'date' => $key,
                'is_today' => $date->isSameDay($today),
                'is_weekend' => $date->isWeekend(),
                'events' => ($diagnostics[$key] ?? collect())->all(),
            ];
        }

        return $days;
    }

    public function getMonthLabel(): string
    {
        return Carbon::create($this->year, $this->month, 1)
            ->locale('fr')
            ->isoFormat('MMMM YYYY');
    }

    public function getStatusColor(string $status): string
    {
        return match ($status) {
            'requested' => 'bg-amber-100 text-amber-800 border-amber-200',
            'scheduled' => 'bg-blue-100 text-blue-800 border-blue-200',
            'in_progress' => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'converted' => 'bg-violet-100 text-violet-800 border-violet-200',
            'cancelled' => 'bg-gray-100 text-gray-600 border-gray-200',
            default => 'bg-gray-100 text-gray-700 border-gray-200',
        };
    }

    public function getStatusLabel(string $status): string
    {
        return match ($status) {
            'requested' => 'Demandé',
            'scheduled' => 'Planifié',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            'converted' => 'Converti',
            'cancelled' => 'Annulé',
            default => $status,
        };
    }
}
