<?php

namespace App\Filament\Resources\FormationRegistrations\Tables;

use App\Models\FormationRegistration;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class FormationRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('session.formation.title')->label('Formation')->searchable()->wrap(),
                TextColumn::make('session.start_date')->label('Date session')->date('d/m/Y'),
                TextColumn::make('user.name')->label('Client')->searchable()->placeholder(fn ($record) => $record->guest_name),
                TextColumn::make('guest_email')->label('Email')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('guest_company')->label('Société')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                        'completed' => 'Terminée',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')->label('Inscrit le')->date('d/m/Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                        'completed' => 'Terminée',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedAcademicCap)
            ->emptyStateHeading('Aucune inscription')
            ->emptyStateDescription('Les inscriptions aux formations apparaîtront ici.')
            ->recordActions([
                Action::make('confirm')
                    ->label('Confirmer')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (FormationRegistration $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmer l\'inscription')
                    ->action(fn (FormationRegistration $record) => $record->update([
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                    ])),
                Action::make('cancel')
                    ->label('Annuler')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (FormationRegistration $record) => in_array($record->status, ['pending', 'confirmed']))
                    ->requiresConfirmation()
                    ->modalHeading('Annuler l\'inscription')
                    ->action(fn (FormationRegistration $record) => $record->update([
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                    ])),
                EditAction::make(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}