<?php

namespace App\Filament\Resources\ProjectTasks\Tables;

use App\Models\ProjectTask;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProjectTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Tâche')
                    ->searchable()
                    ->sortable()
                    ->description(fn (ProjectTask $record) => $record->parent_id
                        ? '↳ Sous-tâche de : '.$record->parent?->title
                        : null),
                TextColumn::make('project.name')
                    ->label('Projet')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('assignee.name')
                    ->label('Assigné à')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'todo' => 'À faire',
                        'in_progress' => 'En cours',
                        'done' => 'Terminé',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'todo' => 'gray',
                        'in_progress' => 'warning',
                        'done' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('weight')
                    ->label('Poids')
                    ->badge()
                    ->color('gray'),
                IconColumn::make('requires_deliverable')
                    ->label('Livrable')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedPaperClip)
                    ->falseIcon(Heroicon::OutlinedMinus)
                    ->trueColor('warning')
                    ->falseColor('gray'),
                TextColumn::make('due_date')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn (ProjectTask $record): ?string => $record->due_date && $record->due_date->isPast() && $record->status !== 'done'
                        ? 'danger'
                        : null),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'todo' => 'À faire',
                        'in_progress' => 'En cours',
                        'done' => 'Terminé',
                    ]),
                SelectFilter::make('project')
                    ->label('Projet')
                    ->relationship('project', 'name'),
                SelectFilter::make('assigned_to')
                    ->label('Assigné à')
                    ->relationship('assignee', 'name'),
            ])
            ->defaultSort('due_date', 'asc')
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentList)
            ->emptyStateHeading('Aucune tâche')
            ->emptyStateDescription('Les tâches créées dans vos projets apparaîtront ici.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
