<?php

namespace App\Livewire;

use App\Mail\DiagnosticRequestedMail;
use App\Models\DiagnosticRequest as DiagnosticModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Diagnostic gratuit ISO')]
class DiagnosticRequest extends Component
{
    // Step tracking
    public int $step = 1;

    public bool $submitted = false;

    public string $reference = '';

    // Step 1 - Client info
    public string $client_name = '';

    public string $client_email = '';

    public string $client_phone = '';

    public string $client_company = '';

    public string $client_address = '';

    // Step 2 - Company profile
    public string $sector = '';

    public string $company_size = '';

    public array $requested_standards = [];

    // Step 3 - Scheduling & notes
    public string $requested_date = '';

    public string $notes = '';

    public string $recaptchaToken = '';

    // Calendar UI state
    public int $calendarYear = 0;

    public int $calendarMonth = 0;

    public string $selectedTime = '';

    public string $pendingTime = '';

    public function mount(): void
    {
        $next = Carbon::tomorrow();
        $this->calendarYear = $next->year;
        $this->calendarMonth = $next->month;
    }

    public function nextStep(): void
    {
        $rules = match ($this->step) {
            1 => [],
            2 => [
                'sector' => 'required|string|max:100',
                'company_size' => 'required|string|in:micro,small,medium,large',
                'requested_standards' => 'required|array|min:1',
                'requested_standards.*' => 'string|in:ISO 9001,ISO 14001,ISO 45001,ISO 22000,ISO 27001',
            ],
            default => [],
        };

        if (! empty($rules)) {
            $this->validate($rules);
        }

        $this->step++;
    }

    public function prevStep(): void
    {
        $this->step = max(1, $this->step - 1);
    }

    public function submit(): void
    {
        $this->validate([
            'client_name' => 'required|string|min:2|max:100',
            'client_email' => 'required|email|max:150',
            'sector' => 'required|string|max:100',
            'company_size' => 'required|string|in:micro,small,medium,large',
            'requested_standards' => 'required|array|min:1',
        ]);

        if (config('services.recaptcha.site_key')) {
            $response = Http::timeout(5)
                ->asForm()
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $this->recaptchaToken,
                    'remoteip' => request()->ip(),
                ]);

            $score = (float) $response->json('score', 0);

            if (! $response->json('success') || $score < (float) config('services.recaptcha.threshold', 0.5)) {
                $this->addError('recaptcha', 'Vérification de sécurité échouée. Veuillez réessayer.');

                return;
            }
        }

        $diagnostic = DiagnosticModel::create([
            'client_name' => $this->client_name,
            'client_email' => $this->client_email,
            'client_phone' => $this->client_phone,
            'client_company' => $this->client_company,
            'client_address' => $this->client_address,
            'sector' => $this->sector,
            'company_size' => $this->company_size,
            'requested_standards' => $this->requested_standards,
            'requested_date' => $this->requested_date ?: null,
            'notes' => $this->selectedTime
                ? '[Créneau souhaité : '.$this->selectedTime.']'.($this->notes ? "\n".$this->notes : '')
                : $this->notes,
            'status' => 'requested',
        ]);

        $this->reference = $diagnostic->reference;

        try {
            Mail::to($diagnostic->client_email, $diagnostic->client_name)
                ->send(new DiagnosticRequestedMail($diagnostic));
        } catch (\Throwable $e) {
            // Silently fail - diagnostic is still created
        }

        $this->submitted = true;
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

    private function getCalendarDays(): array
    {
        if (! $this->calendarYear || ! $this->calendarMonth) {
            return [];
        }

        $firstDay = Carbon::create($this->calendarYear, $this->calendarMonth, 1);
        $daysInMonth = $firstDay->daysInMonth;
        // Convert Sun=0…Sat=6 → Mon=0…Sun=6
        $startDow = ($firstDay->dayOfWeek + 6) % 7;
        $today = Carbon::today();

        // Dates déjà réservées (demandées ou planifiées) dans ce mois
        $bookedDates = DiagnosticModel::whereIn('status', ['requested', 'scheduled'])
            ->whereYear('requested_date', $this->calendarYear)
            ->whereMonth('requested_date', $this->calendarMonth)
            ->whereNotNull('requested_date')
            ->pluck('requested_date')
            ->map(fn ($d) => Carbon::parse($d)->format('Y-m-d'))
            ->all();

        $days = [];
        for ($i = 0; $i < $startDow; $i++) {
            $days[] = null;
        }

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($this->calendarYear, $this->calendarMonth, $d);
            $dateStr = $date->format('Y-m-d');
            $days[] = [
                'day' => $d,
                'date' => $dateStr,
                'available' => ! $date->isWeekend() && $date->greaterThan($today) && ! in_array($dateStr, $bookedDates),
                'booked' => in_array($dateStr, $bookedDates),
                'selected' => $this->requested_date === $dateStr,
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

        return view('livewire.diagnostic-request', compact('calendarDays', 'monthLabel', 'selectedDateLabel', 'timeSlots'));
    }
}
