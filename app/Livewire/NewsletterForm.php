<?php

namespace App\Livewire;

use App\Models\Newsletter;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewsletterForm extends Component
{
    #[Validate('required|email|max:150')]
    public string $email = '';

    #[Validate('nullable|string|max:100')]
    public string $name = '';

    public bool $compact = false;
    public bool $subscribed = false;
    public string $error = '';

    public function subscribe(): void
    {
        $this->validate();

        if (Newsletter::where('email', $this->email)->exists()) {
            $this->error = 'Cette adresse est déjà inscrite.';

            return;
        }

        Newsletter::create([
            'email' => $this->email,
            'name' => $this->name ?: null,
            'is_active' => true,
            'subscribed_at' => now(),
        ]);

        $this->reset(['email', 'name']);
        $this->subscribed = true;
    }

    public function render()
    {
        return view('livewire.newsletter-form');
    }
}
