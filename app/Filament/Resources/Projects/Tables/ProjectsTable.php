<?php

namespace App\Filament\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Projet')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->description ? Str::limit($record->description, 60) : null),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'not_started' => 'Non démarré',
                        'active' => 'En cours',
                        'review' => 'En révision',
                        'completed' => 'Terminé',
                        'archived' => 'Archivé',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'not_started' => 'gray',
                        'active' => 'info',
                        'review' => 'warning',
                        'completed' => 'success',
                        'archived' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('progress')
                    ->label('Progression')
                    ->state(fn ($record) => $record->progress.'%')
                    ->badge()
                    ->color(fn ($record) => match (true) {
                        $record->progress >= 100 => 'success',
                        $record->progress >= 50 => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('creator.name')
                    ->label('Responsable')
                    ->sortable(),
                TextColumn::make('due_date')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record) => $record->due_date && $record->due_date->isPast() && in_array($record->status, ['not_started', 'active', 'review']) ? 'danger' : null),
                TextColumn::make('allTasks_count')
                    ->label('Tâches')
                    ->counts('allTasks')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'not_started' => 'Non démarré',
                        'active' => 'En cours',
                        'review' => 'En révision',
                        'completed' => 'Terminé',
                        'archived' => 'Archivé',
                    ]),
                SelectFilter::make('created_by')
                    ->label('Responsable')
                    ->relationship('creator', 'name'),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedFolderOpen)
            ->emptyStateHeading('Aucun projet')
            ->emptyStateDescription('Créez votre premier projet à partir d\'un devis, d\'un audit ou de zéro.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
