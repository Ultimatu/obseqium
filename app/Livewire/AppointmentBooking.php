<?php

namespace App\Livewire;

use App\Models\Appointment;
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

    public bool $booked = false;

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

    public function book(): void
    {
        $this->validate([
            'guest_name'     => 'required|string|min:2|max:100',
            'guest_email'    => 'required|email|max:150',
            'type'           => 'required|in:visio,presential',
            'requested_date' => 'required|date|after:today',
        ]);

        Appointment::create([
            'guest_name' => $this->guest_name,
            'guest_email' => $this->guest_email,
            'guest_phone' => $this->guest_phone,
            'guest_company' => $this->guest_company,
            'type' => $this->type,
            'subject' => $this->subject,
            'requested_date' => $this->requested_date,
            'status' => 'pending',
        ]);

        $this->booked = true;
    }

    public function render()
    {
        return view('livewire.appointment-booking');
    }
}
