<?php

namespace App\Livewire;

use App\Models\Quote;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.app')]
#[Title('Votre devis')]
class QuotePortal extends Component
{
    use WithFileUploads;

    public Quote $quote;

    public bool $approved = false;

    public bool $confirmingApproval = false;

    public ?string $clientComment = null;

    public $approvalFile = null;

    public bool $fileUploaded = false;

    public function mount(string $token): void
    {
        $this->quote = Quote::with('items')
            ->where('token', $token)
            ->firstOrFail();

        // Track first view
        if (! $this->quote->viewed_at && in_array($this->quote->status, ['sent'])) {
            $this->quote->update(['status' => 'viewed', 'viewed_at' => now()]);
        }

        $this->approved = $this->quote->status === 'accepted';
    }

    public function approve(): void
    {
        if (! $this->quote->isPending()) {
            return;
        }

        $this->quote->update([
            'status' => 'accepted',
            'approved_at' => now(),
            'responded_at' => now(),
        ]);

        $this->approved = true;
        $this->confirmingApproval = false;
        $this->quote->refresh();
    }

    public function uploadApprovalDocument(): void
    {
        $this->validate([
            'approvalFile' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ], [
            'approvalFile.required' => 'Veuillez sélectionner un fichier.',
            'approvalFile.mimes' => 'Formats acceptés : PDF, JPG, PNG.',
            'approvalFile.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
        ]);

        $path = $this->approvalFile->storeAs(
            'quotes/approvals',
            $this->quote->reference.'_bon-accord.'.$this->approvalFile->getClientOriginalExtension(),
            'public'
        );

        $this->quote->update(['approval_document' => $path]);
        $this->quote->refresh();

        $this->approvalFile = null;
        $this->fileUploaded = true;
    }

    public function render()
    {
        return view('livewire.quote-portal');
    }
}
