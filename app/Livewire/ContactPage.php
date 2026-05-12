<?php

namespace App\Livewire;

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Contact')]
class ContactPage extends Component
{
    #[Validate('required|string|min:2|max:100')]
    public string $name = '';

    #[Validate('required|email|max:150')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('nullable|string|max:100')]
    public string $company = '';

    #[Validate('required|string|min:3|max:150')]
    public string $subject = '';

    #[Validate('nullable|in:presentiel,visio,client')]
    public string $meeting_format = '';

    #[Validate('required|string|min:10|max:2000')]
    public string $message = '';

    public bool $sent = false;

    public function send(): void
    {
        $this->validate();

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company' => $this->company,
            'subject' => $this->subject,
            'meeting_format' => $this->meeting_format ?: null,
            'message' => $this->message,
        ]);

        $this->reset(['name', 'email', 'phone', 'company', 'subject', 'meeting_format', 'message']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.contact-page');
    }
}
