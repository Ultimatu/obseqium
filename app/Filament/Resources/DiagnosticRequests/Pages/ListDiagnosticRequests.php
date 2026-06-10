<?php

namespace App\Filament\Resources\DiagnosticRequests\Pages;

use App\Filament\Resources\DiagnosticRequests\DiagnosticRequestResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListDiagnosticRequests extends ListRecords
{
    protected static string $resource = DiagnosticRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('calendar')
                ->label('Calendrier')
                ->icon(Heroicon::OutlinedCalendarDays)
                ->color('gray')
                ->url(route('admin.diagnostic-calendar'))
                ->openUrlInNewTab(),
            CreateAction::make(),
        ];
    }
}
