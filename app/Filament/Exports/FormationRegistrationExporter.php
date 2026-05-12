<?php

namespace App\Filament\Exports;

use App\Models\FormationRegistration;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class FormationRegistrationExporter extends Exporter
{
    protected static ?string $model = FormationRegistration::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('session.formation.title')->label('Formation'),
            ExportColumn::make('session.start_date')->label('Date de session'),
            ExportColumn::make('session.city')->label('Ville'),
            ExportColumn::make('guest_name')->label('Participant'),
            ExportColumn::make('guest_email')->label('Email'),
            ExportColumn::make('guest_phone')->label('Téléphone'),
            ExportColumn::make('guest_company')->label('Entreprise'),
            ExportColumn::make('status')->label('Statut'),
            ExportColumn::make('confirmed_at')->label('Confirmé le'),
            ExportColumn::make('created_at')->label('Inscrit le'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = Number::format($export->successful_rows).' inscription(s) exportée(s).';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' ligne(s) en erreur.';
        }

        return $body;
    }
}
