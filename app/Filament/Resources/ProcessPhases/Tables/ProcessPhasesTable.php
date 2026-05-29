<?php

namespace App\Filament\Resources\ProcessPhases\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProcessPhasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('N°')
                    ->sortable()
                    ->width('50px'),
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->weight('font-semibold'),
                TextColumn::make('badge')
                    ->label('Badge')
                    ->badge()
                    ->color(fn (?string $state): string => $state ? 'success' : 'gray')
                    ->formatStateUsing(fn ($state) => $state ?: '-'),
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->emptyStateIcon(Heroicon::OutlinedQueueList)
            ->emptyStateHeading('Aucune phase définie')
            ->emptyStateDescription('Créez les phases de votre processus d\'accompagnement.')
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
