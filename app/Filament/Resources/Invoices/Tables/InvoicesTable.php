<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Models\Invoice;
use App\Models\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Symfony\Component\HttpFoundation\Response;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->label('Référence')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('client_name')
                    ->label('Client')
                    ->searchable(),

                TextColumn::make('client_company')
                    ->label('Société')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('total')
                    ->label('Total TTC')
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Brouillon',
                        'sent' => 'Envoyée',
                        'paid' => 'Payée',
                        'overdue' => 'En retard',
                        'cancelled' => 'Annulée',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'sent' => 'info',
                        'paid' => 'success',
                        'overdue' => 'danger',
                        'cancelled' => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('issued_at')
                    ->label('Émise le')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('due_at')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->color(fn (Invoice $record): string => $record->due_at->isPast() && $record->status === 'sent' ? 'danger' : 'gray')
                    ->sortable(),

                TextColumn::make('paid_at')
                    ->label('Payée le')
                    ->date('d/m/Y')
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('quote.reference')
                    ->label('Devis')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->native(false)
                    ->options([
                        'draft' => 'Brouillon',
                        'sent' => 'Envoyée',
                        'paid' => 'Payée',
                        'overdue' => 'En retard',
                        'cancelled' => 'Annulée',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedDocumentText)
            ->emptyStateHeading('Aucune facture')
            ->emptyStateDescription('Les factures générées depuis les devis acceptés apparaîtront ici.')
            ->recordActions([
                Action::make('mark_paid')
                    ->label('Marquer payée')
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->color('success')
                    ->visible(fn (Invoice $record) => $record->status === 'sent')
                    ->requiresConfirmation()
                    ->action(fn (Invoice $record) => $record->update(['status' => 'paid', 'paid_at' => now()])),

                Action::make('download_pdf')
                    ->label('PDF')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->action(function (Invoice $record): Response {
                        $record->load('items', 'quote');
                        $settings = SiteSetting::getAllCached();

                        $pdf = Pdf::loadView('pdfs.invoice', [
                            'invoice' => $record,
                            'settings' => $settings,
                            'currency' => $settings->get('quote_currency', 'XOF'),
                        ])->setPaper('a4');

                        $filename = 'facture-'.$record->reference.'.pdf';

                        return response($pdf->output(), 200, [
                            'Content-Type' => 'application/pdf',
                            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
                        ]);
                    }),

                Action::make('cancel')
                    ->label('Annuler')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (Invoice $record) => in_array($record->status, ['draft', 'sent']))
                    ->requiresConfirmation()
                    ->action(fn (Invoice $record) => $record->update(['status' => 'cancelled'])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
