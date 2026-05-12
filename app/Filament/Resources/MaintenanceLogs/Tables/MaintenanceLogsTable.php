<?php

namespace App\Filament\Resources\MaintenanceLogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MaintenanceLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('started_at')
                    ->label('Début')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('ended_at')
                    ->label('Fin')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('En cours…')
                    ->sortable(),

                TextColumn::make('duration')
                    ->label('Durée')
                    ->state(fn ($record) => $record->duration ?? '—')
                    ->badge()
                    ->color(fn ($record) => $record->ended_at ? 'gray' : 'warning'),

                TextColumn::make('startedBy.name')
                    ->label('Activé par')
                    ->placeholder('—'),

                TextColumn::make('endedBy.name')
                    ->label('Désactivé par')
                    ->placeholder('—'),

                TextColumn::make('message')
                    ->label('Message')
                    ->limit(60)
                    ->placeholder('—')
                    ->toggleable(),

                TextColumn::make('notes')
                    ->label('Notes internes')
                    ->limit(60)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Filter::make('active')
                    ->label('En cours')
                    ->query(fn (Builder $query) => $query->whereNull('ended_at')),
            ])
            ->defaultSort('started_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedWrenchScrewdriver)
            ->emptyStateHeading('Aucun historique')
            ->emptyStateDescription('Les périodes de maintenance apparaîtront ici.')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
