<?php

namespace App\Livewire;

use App\Mail\DiagnosticRequestedMail;
use App\Models\DiagnosticRequest as DiagnosticModel;
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

    // Step 1 — Client info
    public string $client_name = '';

    public string $client_email = '';

    public string $client_phone = '';

    public string $client_company = '';

    public string $client_address = '';

    // Step 2 — Company profile
    public string $sector = '';

    public string $company_size = '';

    public array $requested_standards = [];

    // Step 3 — Scheduling & notes
    public string $requested_date = '';

    public string $notes = '';

    public string $recaptchaToken = '';

    public function nextStep(): void
    {
        $this->validate(match ($this->step) {
            1 => [
                'client_name' => 'required|string|min:2|max:100',
                'client_email' => 'required|email|max:150',
                'client_phone' => 'nullable|string|max:20',
            ],
            2 => [
                'sector' => 'required|string|max:100',
                'company_size' => 'required|string|in:micro,small,medium,large',
                'requested_standards' => 'required|array|min:1',
                'requested_standards.*' => 'string|in:ISO 9001,ISO 14001,ISO 45001,ISO 22000,ISO 27001',
            ],
            default => [],
        });

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
            'notes' => $this->notes,
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

    public function render()
    {
        return view('livewire.diagnostic-request');
    }
}
