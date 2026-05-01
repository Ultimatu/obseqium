<?php

namespace App\Filament\Resources\FormationSessions\Pages;

use App\Filament\Resources\FormationSessions\FormationSessionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFormationSession extends EditRecord
{
    protected static string $resource = FormationSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
