<?php

namespace App\Filament\Resources\FormationSessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormationSessionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('formation.title')->label('Formation')->searchable()->wrap(),
                TextColumn::make('start_date')->label('Début')->date('d/m/Y')->sortable(),
                TextColumn::make('end_date')->label('Fin')->date('d/m/Y')->sortable(),
                TextColumn::make('city')->label('Ville'),
                TextColumn::make('current_participants')->label('Inscrits')->numeric()->suffix(fn ($record) => '/'.$record->max_participants),
                TextColumn::make('status')->label('Statut')->badge()->formatStateUsing(fn ($state) => match ($state) {
                    'open' => 'Ouverte', 'full' => 'Complète', 'cancelled' => 'Annulée', 'completed' => 'Terminée', default => $state,
                })->color(fn ($state) => match ($state) {
                    'open' => 'success', 'full' => 'warning', 'cancelled' => 'danger', 'completed' => 'gray', default => 'gray',
                }),
                IconColumn::make('is_published')->label('Publiée')->boolean(),
            ])
            ->filters([SelectFilter::make('status')->label('Statut')->options(['open' => 'Ouverte', 'full' => 'Complète', 'cancelled' => 'Annulée', 'completed' => 'Terminée'])])
            ->defaultSort('start_date', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedCalendarDays)
            ->emptyStateHeading('Aucune session de formation')
            ->emptyStateDescription('Planifiez des sessions pour vos formations.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}