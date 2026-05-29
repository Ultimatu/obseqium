<?php

namespace App\Filament\Resources\Quotes\Tables;

use App\Filament\Exports\QuoteExporter;
use App\Mail\QuoteSentMail;
use App\Models\Invoice;
use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;

class QuotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->label('Référence')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('client_name')
                    ->label('Client')
                    ->searchable()
                    ->description(fn ($record) => $record->client_company),
                TextColumn::make('client_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('service_type')
                    ->label('Prestation')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'strategic' => 'Stratégique',
                        'audit' => 'Audit',
                        'qhse' => 'Conseil QHSE',
                        'training' => 'Formation',
                        default => 'Autre',
                    })
                    ->colors([
                        'info' => 'strategic',
                        'warning' => 'audit',
                        'success' => 'qhse',
                        'primary' => 'training',
                    ]),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'draft' => 'Brouillon',
                        'sent' => 'Envoyé',
                        'viewed' => 'Consulté',
                        'accepted' => 'Accepté',
                        'refused' => 'Refusé',
                        'revision_requested' => 'Révision demandée',
                        default => $state,
                    })
                    ->colors([
                        'gray' => 'draft',
                        'info' => 'sent',
                        'warning' => 'viewed',
                        'success' => 'accepted',
                        'danger' => 'refused',
                        'primary' => 'revision_requested',
                    ]),
                IconColumn::make('approval_document')
                    ->label('BPA')
                    ->tooltip('Bon pour accord')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedPaperClip)
                    ->falseIcon(Heroicon::OutlinedMinus)
                    ->trueColor('success')
                    ->falseColor('gray'),
                TextColumn::make('total')
                    ->label('Total TTC')
                    ->money('XOF')
                    ->sortable(),
                TextColumn::make('valid_until')
                    ->label('Valable jusqu\'au')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'draft' => 'Brouillon',
                        'sent' => 'Envoyé',
                        'viewed' => 'Consulté',
                        'accepted' => 'Accepté',
                        'refused' => 'Refusé',
                        'revision_requested' => 'Révision demandée',
                    ]),
                SelectFilter::make('service_type')
                    ->label('Prestation')
                    ->options([
                        'strategic' => 'Accompagnement stratégique',
                        'audit' => 'Audit',
                        'qhse' => 'Conseil QHSE',
                        'training' => 'Formation',
                        'other' => 'Autre',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedDocumentText)
            ->emptyStateHeading('Aucun devis')
            ->emptyStateDescription('Les devis créés apparaîtront ici.')
            ->recordActions([
                Action::make('sendEmail')
                    ->label('Envoyer par email')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('info')
                    ->visible(fn (Quote $record) => in_array($record->status, ['draft', 'sent']))
                    ->requiresConfirmation()
                    ->modalHeading('Envoyer le devis par email')
                    ->modalDescription(fn (Quote $record) => "Un email avec le lien du portail client sera envoyé à {$record->client_email}.")
                    ->modalSubmitActionLabel('Envoyer')
                    ->action(function (Quote $record): void {
                        Mail::to($record->client_email, $record->client_name)
                            ->send(new QuoteSentMail($record));

                        $record->update(['status' => 'sent', 'sent_at' => now()]);

                        Notification::make()
                            ->title("Devis {$record->reference} envoyé à {$record->client_email}")
                            ->success()
                            ->send();
                    }),
                Action::make('copyPortalLink')
                    ->label('Lien portail')
                    ->icon(Heroicon::OutlinedLink)
                    ->color('gray')
                    ->visible(fn (Quote $record) => ! in_array($record->status, ['draft']))
                    ->action(function (Quote $record, Action $action): void {
                        $action->halt();
                    })
                    ->extraAttributes(fn (Quote $record) => [
                        'x-data' => '',
                        'x-on:click.stop' => "navigator.clipboard.writeText('{$record->portalUrl()}').then(() => { \$dispatch('notify', 'Lien copié !') })",
                    ]),
                Action::make('downloadPdf')
                    ->label('PDF')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->visible(fn (Quote $record) => filled($record->token))
                    ->url(fn (Quote $record) => route('quotes.portal.pdf', $record->token))
                    ->openUrlInNewTab(),
                Action::make('accept')
                    ->label('Accepter')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (Quote $record) => in_array($record->status, ['sent', 'viewed', 'revision_requested']))
                    ->requiresConfirmation()
                    ->modalHeading('Marquer le devis comme accepté')
                    ->action(fn (Quote $record) => $record->update(['status' => 'accepted', 'approved_at' => now(), 'responded_at' => now()])),
                Action::make('refuse')
                    ->label('Refuser')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (Quote $record) => in_array($record->status, ['sent', 'viewed', 'revision_requested']))
                    ->requiresConfirmation()
                    ->modalHeading('Marquer le devis comme refusé')
                    ->action(fn (Quote $record) => $record->update(['status' => 'refused', 'responded_at' => now()])),

                Action::make('generate_invoice')
                    ->label('Générer facture')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('info')
                    ->visible(fn (Quote $record) => $record->status === 'accepted' && ! Invoice::where('quote_id', $record->id)->exists())
                    ->requiresConfirmation()
                    ->modalHeading('Générer une facture')
                    ->modalDescription('Une facture sera créée avec les mêmes lignes que ce devis.')
                    ->action(function (Quote $record): void {
                        $record->load('items');
                        $invoice = Invoice::fromQuote($record);

                        Notification::make()
                            ->title('Facture créée')
                            ->body('Facture '.$invoice->reference.' générée avec succès.')
                            ->success()
                            ->send();
                    }),

                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()->exporter(QuoteExporter::class)->label('Exporter'),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
