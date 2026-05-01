<?php

namespace App\Filament\Resources\Quotes\Tables;

use App\Models\Quote;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

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
                TextColumn::make('total')
                    ->label('Total TTC')
                    ->money('EUR')
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
                Action::make('send')
                    ->label('Envoyer')
                    ->icon(Heroicon::OutlinedPaperAirplane)
                    ->color('info')
                    ->visible(fn (Quote $record) => $record->status === 'draft')
                    ->requiresConfirmation()
                    ->modalHeading('Marquer le devis comme envoyé')
                    ->action(fn (Quote $record) => $record->update(['status' => 'sent', 'sent_at' => now()])),
                Action::make('accept')
                    ->label('Accepter')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (Quote $record) => in_array($record->status, ['sent', 'viewed', 'revision_requested']))
                    ->requiresConfirmation()
                    ->modalHeading('Marquer le devis comme accepté')
                    ->action(fn (Quote $record) => $record->update(['status' => 'accepted', 'responded_at' => now()])),
                Action::make('refuse')
                    ->label('Refuser')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (Quote $record) => in_array($record->status, ['sent', 'viewed', 'revision_requested']))
                    ->requiresConfirmation()
                    ->modalHeading('Marquer le devis comme refusé')
                    ->action(fn (Quote $record) => $record->update(['status' => 'refused', 'responded_at' => now()])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
