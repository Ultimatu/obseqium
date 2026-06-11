<?php

namespace App\Filament\Resources\Projects\Pages;

use App\Filament\Resources\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $record = $this->record;

        if (($this->data['status'] ?? null) !== 'completed' || $record->status === 'completed') {
            return;
        }

        if ($record->hasUnfinishedTasks()) {
            $remaining = $record->allTasks()->whereNull('parent_id')->where('status', '!=', 'done')->count();

            Notification::make()
                ->title('Tâches non terminées')
                ->body("$remaining tâche(s) ne sont pas encore terminées. Terminez-les avant de clôturer le projet.")
                ->danger()
                ->send();
            $this->halt();
        }
    }
}
