<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('')->disk('public'),
                TextColumn::make('title')->label('Titre')->searchable()->sortable(),
                TextColumn::make('type')->label('Type')->badge()->formatStateUsing(fn ($state) => match ($state) {
                    'strategic' => 'Stratégique', 'audit' => 'Audit', 'qhse' => 'QHSE', 'training' => 'Formation', default => $state,
                }),
                TextColumn::make('order')->label('Ordre')->numeric()->sortable(),
                IconColumn::make('is_active')->label('Actif')->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->emptyStateIcon(Heroicon::OutlinedBriefcase)
            ->emptyStateHeading('Aucun service')
            ->emptyStateDescription('Ajoutez les services proposés par le cabinet.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}