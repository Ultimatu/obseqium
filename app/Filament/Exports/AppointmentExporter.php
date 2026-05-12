<?php

namespace App\Filament\Exports;

use App\Models\Appointment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class AppointmentExporter extends Exporter
{
    protected static ?string $model = Appointment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('guest_name')->label('Nom'),
            ExportColumn::make('guest_email')->label('Email'),
            ExportColumn::make('guest_phone')->label('Téléphone'),
            ExportColumn::make('guest_company')->label('Entreprise'),
            ExportColumn::make('type')->label('Type'),
            ExportColumn::make('status')->label('Statut'),
            ExportColumn::make('subject')->label('Sujet'),
            ExportColumn::make('requested_date')->label('Date demandée'),
            ExportColumn::make('confirmed_date')->label('Date confirmée'),
            ExportColumn::make('created_at')->label('Créé le'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = Number::format($export->successful_rows).' rendez-vous exporté(s).';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' ligne(s) en erreur.';
        }

        return $body;
    }
}
