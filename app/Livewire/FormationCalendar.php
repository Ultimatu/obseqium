<?php

namespace App\Livewire;

use App\Models\FormationSession;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Calendrier des formations')]
class FormationCalendar extends Component
{
    public int $currentYear;

    public int $currentMonth;

    public function mount(): void
    {
        $this->currentYear = now()->year;
        $this->currentMonth = now()->month;
    }

    public function previousMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
    }

    public function nextMonth(): void
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
    }

    public function render(): View
    {
        $sessions = FormationSession::published()
            ->with('formation')
            ->whereYear('start_date', $this->currentYear)
            ->whereMonth('start_date', $this->currentMonth)
            ->orderBy('start_date')
            ->get();

        $monthStart = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $monthEnd = $monthStart->copy()->endOfMonth();
        $calendarStart = $monthStart->copy()->startOfWeek(Carbon::MONDAY);
        $calendarEnd = $monthEnd->copy()->endOfWeek(Carbon::SUNDAY);

        $weeks = [];
        $current = $calendarStart->copy();

        while ($current->lte($calendarEnd)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $day = $current->copy();
                $week[] = [
                    'date' => $day,
                    'isCurrentMonth' => $day->month === $this->currentMonth,
                    'sessions' => $sessions->filter(
                        fn ($s) => $s->start_date->isSameDay($day)
                    ),
                ];
                $current->addDay();
            }
            $weeks[] = $week;
        }

        return view('livewire.formation-calendar', [
            'weeks' => $weeks,
            'monthStart' => $monthStart,
            'sessions' => $sessions,
        ]);
    }
}
