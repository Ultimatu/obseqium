<?php

namespace App\Filament\Resources\Pricings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PricingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Clé')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'default' ? 'success' : 'gray'),
                TextColumn::make('hero_title')
                    ->label('Titre')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('example_total_amount')
                    ->label('Montant exemple')
                    ->formatStateUsing(fn ($state) => number_format($state, 0, ',', ' ').' FCFA'),
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
            ])
            ->defaultSort('key')
            ->emptyStateIcon(Heroicon::OutlinedBanknotes)
            ->emptyStateHeading('Aucune configuration tarifaire')
            ->emptyStateDescription('Créez une configuration pour personnaliser la page tarifs.')
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
