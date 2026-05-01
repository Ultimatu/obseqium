<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Politique de confidentialité')]
class PrivacyPage extends Component
{
    public function render()
    {
        return view('livewire.privacy-page');
    }
}
