<?php

namespace App\Filament\Resources\ProjectTasks\Pages;

use App\Filament\Resources\ProjectTasks\ProjectTaskResource;
use App\Filament\Resources\ProjectTasks\Schemas\ProjectTaskForm;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditProjectTask extends EditRecord
{
    protected static string $resource = ProjectTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function form(Schema $schema): Schema
    {
        return ProjectTaskForm::configure($schema);
    }

    protected function beforeSave(): void
    {
        $record = $this->record;

        if (($this->data['status'] ?? null) !== 'done' || $record->status === 'done') {
            return;
        }

        $checklists = $this->data['checklists'] ?? [];
        $hasUnchecked = collect($checklists)->contains(fn ($item) => empty($item['is_completed']));

        if ($hasUnchecked) {
            Notification::make()
                ->title('Checklist incomplète')
                ->body('Tous les éléments de la checklist doivent être cochés avant de terminer cette tâche.')
                ->danger()
                ->send();
            $this->halt();
        }

        $requiresDeliverable = (bool) ($this->data['requires_deliverable'] ?? $record->requires_deliverable);

        if ($requiresDeliverable && $record->deliverables()->count() === 0) {
            Notification::make()
                ->title('Livrable manquant')
                ->body('Un livrable doit être fourni avant de terminer cette tâche.')
                ->danger()
                ->send();
            $this->halt();
        }
    }
}
