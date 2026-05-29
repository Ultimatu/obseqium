<?php

namespace App\Filament\Resources\DiagnosticRequests\Pages;

use App\Filament\Resources\DiagnosticRequests\DiagnosticRequestResource;
use Filament\Resources\Pages\ListRecords;

class ListDiagnosticRequests extends ListRecords
{
    protected static string $resource = DiagnosticRequestResource::class;
}
