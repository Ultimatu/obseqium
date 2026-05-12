<?php

namespace App\Filament\Exports;

use App\Models\Contact;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class ContactExporter extends Exporter
{
    protected static ?string $model = Contact::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Nom'),
            ExportColumn::make('email')->label('Email'),
            ExportColumn::make('phone')->label('Téléphone'),
            ExportColumn::make('company')->label('Entreprise'),
            ExportColumn::make('subject')->label('Sujet'),
            ExportColumn::make('message')->label('Message'),
            ExportColumn::make('is_read')->label('Lu'),
            ExportColumn::make('created_at')->label('Reçu le'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = Number::format($export->successful_rows).' contact(s) exporté(s).';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' ligne(s) en erreur.';
        }

        return $body;
    }
}
