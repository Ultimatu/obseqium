<?php

namespace App\Filament\Exports;

use App\Models\Quote;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class QuoteExporter extends Exporter
{
    protected static ?string $model = Quote::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('reference')->label('Référence'),
            ExportColumn::make('client_name')->label('Client'),
            ExportColumn::make('client_email')->label('Email'),
            ExportColumn::make('client_phone')->label('Téléphone'),
            ExportColumn::make('client_company')->label('Entreprise'),
            ExportColumn::make('service_type')->label('Type de service'),
            ExportColumn::make('sector')->label('Secteur'),
            ExportColumn::make('status')->label('Statut'),
            ExportColumn::make('subtotal')->label('HT'),
            ExportColumn::make('tax_amount')->label('TVA'),
            ExportColumn::make('total')->label('TTC'),
            ExportColumn::make('valid_until')->label('Valide jusqu\'au'),
            ExportColumn::make('sent_at')->label('Envoyé le'),
            ExportColumn::make('approved_at')->label('Approuvé le'),
            ExportColumn::make('created_at')->label('Créé le'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = Number::format($export->successful_rows).' '.str('devis')->plural($export->successful_rows).' exporté(s).';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.Number::format($failedRowsCount).' ligne(s) en erreur.';
        }

        return $body;
    }
}
