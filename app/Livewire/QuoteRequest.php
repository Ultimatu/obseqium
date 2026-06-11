<?php

namespace App\Livewire;

use App\Models\Quote;
use App\Models\Service;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Demande de devis')]
class QuoteRequest extends Component
{
    public int $step = 1;

    // Step 1 - Client info
    public string $client_name = '';

    public string $client_email = '';

    public string $client_phone = '';

    public string $client_company = '';

    public string $client_job_title = '';

    // Step 2 - Project
    public string $service_type = '';

    public string $sector = '';

    public string $company_size = '';

    public string $description = '';

    public bool $submitted = false;

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
                'service_type' => 'required|string',
                'description' => 'required|string|min:10|max:3000',
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
            'service_type' => 'required|string',
            'description' => 'required|string|min:10|max:3000',
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

        Quote::create([
            'client_name' => $this->client_name,
            'client_email' => $this->client_email,
            'client_phone' => $this->client_phone,
            'client_company' => $this->client_company,
            'client_job_title' => $this->client_job_title,
            'service_type' => $this->service_type,
            'sector' => $this->sector,
            'company_size' => $this->company_size,
            'description' => $this->description,
            'status' => 'draft',
        ]);

        $this->submitted = true;
    }

    #[Computed]
    public function services(): Collection
    {
        return Service::active()->get();
    }

    public function render()
    {
        return view('livewire.quote-request');
    }
}
