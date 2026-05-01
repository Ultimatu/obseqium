<?php

namespace App\Filament\Resources\References\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReferencesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('client_logo')->label('Logo')->disk('public'),
                TextColumn::make('title')->label('Étude de cas')->searchable()->wrap(),
                TextColumn::make('client_name')->label('Client')->description(fn ($record) => $record->sector),
                IconColumn::make('is_featured')->label('Vedette')->boolean(),
                IconColumn::make('is_active')->label('Actif')->boolean(),
                TextColumn::make('order')->label('Ordre')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->emptyStateIcon(Heroicon::OutlinedBuildingOffice)
            ->emptyStateHeading('Aucune référence client')
            ->emptyStateDescription('Ajoutez vos études de cas et références clients.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}