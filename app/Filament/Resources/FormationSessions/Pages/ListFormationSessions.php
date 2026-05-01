<?php

namespace App\Filament\Resources\FormationSessions\Pages;

use App\Filament\Resources\FormationSessions\FormationSessionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormationSessions extends ListRecords
{
    protected static string $resource = FormationSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
