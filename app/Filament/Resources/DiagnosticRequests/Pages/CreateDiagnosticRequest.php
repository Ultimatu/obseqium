<?php

namespace App\Filament\Resources\DiagnosticRequests\Pages;

use App\Filament\Resources\DiagnosticRequests\DiagnosticRequestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDiagnosticRequest extends CreateRecord
{
    protected static string $resource = DiagnosticRequestResource::class;

    protected function fillForm(): void
    {
        $this->callHook('beforeFill');

        $date = request()->query('date');

        $this->form->fill($date ? ['scheduled_date' => $date] : []);

        $this->callHook('afterFill');
    }
}
