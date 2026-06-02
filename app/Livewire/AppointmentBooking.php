<?php

namespace App\Livewire;

use App\Models\Appointment;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Prendre rendez-vous')]
class AppointmentBooking extends Component
{
    public int $step = 1;

    // Step 1 — Identity
    public string $guest_name = '';
    public string $guest_email = '';
    public string $guest_phone = '';
    public string $guest_company = '';

    // Step 2 — Format
    public string $type = 'visio';
    public string $subject = '';

    // Step 3 — Date
    public string $requested_date = '';

    // Calendar UI state
    public int $calendarYear = 0;
    public int $calendarMonth = 0;
    public string $selectedTime = '';
    public string $pendingTime = '';

    public bool $booked = false;

    public function mount(): void
    {
        $next = Carbon::tomorrow();
        $this->calendarYear = $next->year;
        $this->calendarMonth = $next->month;
    }

    public function nextStep(): void
    {
        $this->validate(match ($this->step) {
            1 => [
                'guest_name'  => 'required|string|min:2|max:100',
                'guest_email' => 'required|email|max:150',
                'guest_phone' => 'nullable|string|max:20',
            ],
            2 => [
                'type' => 'required|in:visio,presential',
            ],
            default => [],
        });

        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function prevMonth(): void
    {
        $target = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->subMonth();
        if ($target->greaterThanOrEqualTo(Carbon::now()->startOfMonth())) {
            $this->calendarYear = $target->year;
            $this->calendarMonth = $target->month;
        }
    }

    public function nextMonth(): void
    {
        $target = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->addMonth();
        if ($target->lessThanOrEqualTo(Carbon::now()->addMonths(3))) {
            $this->calendarYear = $target->year;
            $this->calendarMonth = $target->month;
        }
    }

    public function selectCalendarDate(string $date): void
    {
        $this->requested_date = $date;
        $this->pendingTime = '';
        $this->selectedTime = '';
    }

    public function pickTime(string $time): void
    {
        $this->pendingTime = $time;
    }

    public function confirmTime(): void
    {
        $this->selectedTime = $this->pendingTime;
    }

    public function book(): void
    {
        $this->validate([
            'guest_name'     => 'required|string|min:2|max:100',
            'guest_email'    => 'required|email|max:150',
            'type'           => 'required|in:visio,presential',
            'requested_date' => 'required|date|after:today',
        ]);

        Appointment::create([
            'guest_name'     => $this->guest_name,
            'guest_email'    => $this->guest_email,
            'guest_phone'    => $this->guest_phone,
            'guest_company'  => $this->guest_company,
            'type'           => $this->type,
            'subject'        => $this->subject,
            'requested_date' => $this->requested_date
                ? $this->requested_date . ($this->selectedTime ? ' ' . $this->selectedTime : '')
                : null,
            'status'         => 'pending',
        ]);

        $this->booked = true;
    }

    private function getCalendarDays(): array
    {
        if (! $this->calendarYear || ! $this->calendarMonth) {
            return [];
        }

        $firstDay = Carbon::create($this->calendarYear, $this->calendarMonth, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startDow = ($firstDay->dayOfWeek + 6) % 7;
        $today = Carbon::today();

        $bookedDates = Appointment::whereIn('status', ['pending', 'confirmed'])
            ->whereYear('requested_date', $this->calendarYear)
            ->whereMonth('requested_date', $this->calendarMonth)
            ->whereNotNull('requested_date')
            ->pluck('requested_date')
            ->map(fn($d) => Carbon::parse($d)->format('Y-m-d'))
            ->all();

        $days = [];
        for ($i = 0; $i < $startDow; $i++) {
            $days[] = null;
        }

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($this->calendarYear, $this->calendarMonth, $d);
            $dateStr = $date->format('Y-m-d');
            $days[] = [
                'day'       => $d,
                'date'      => $dateStr,
                'available' => ! $date->isWeekend() && $date->greaterThan($today) && ! in_array($dateStr, $bookedDates),
                'booked'    => in_array($dateStr, $bookedDates),
                'selected'  => $this->requested_date === $dateStr,
            ];
        }

        return $days;
    }

    public function render()
    {
        $calendarDays = $this->getCalendarDays();
        $monthLabel = $this->calendarYear
            ? Carbon::create($this->calendarYear, $this->calendarMonth, 1)->locale('fr')->isoFormat('MMMM YYYY')
            : '';
        $selectedDateLabel = $this->requested_date
            ? Carbon::parse($this->requested_date)->locale('fr')->isoFormat('dddd D MMMM')
            : null;
        $timeSlots = ['09:00', '10:30', '14:00', '15:30', '17:00'];

        return view('livewire.appointment-booking', compact('calendarDays', 'monthLabel', 'selectedDateLabel', 'timeSlots'));
    }
}
