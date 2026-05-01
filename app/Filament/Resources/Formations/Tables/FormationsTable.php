<?php

namespace App\Filament\Resources\Formations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('')
                    ->circular()
                    ->disk('public'),
                TextColumn::make('title')
                    ->label('Intitulé')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                TextColumn::make('thematic')
                    ->label('Thématique')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'qualite' => 'Qualité',
                        'securite' => 'Sécurité',
                        'environnement' => 'Environnement',
                        'reglementation' => 'Réglementation',
                        'management' => 'Management',
                        default => $state,
                    }),
                TextColumn::make('format')
                    ->label('Format')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'presential' => 'Présentiel',
                        'online' => 'En ligne',
                        'hybrid' => 'Hybride',
                        default => $state,
                    }),
                TextColumn::make('duration_hours')
                    ->label('Durée')
                    ->suffix('h')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Tarif')
                    ->money('EUR')
                    ->sortable()
                    ->placeholder('Sur demande'),
                TextColumn::make('sessions_count')
                    ->label('Sessions')
                    ->counts('sessions')
                    ->badge(),
                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean(),
                IconColumn::make('is_featured')
                    ->label('Vedette')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('thematic')
                    ->label('Thématique')
                    ->options([
                        'qualite' => 'Qualité',
                        'securite' => 'Sécurité',
                        'environnement' => 'Environnement',
                        'reglementation' => 'Réglementation',
                        'management' => 'Management',
                    ]),
                SelectFilter::make('format')
                    ->label('Format')
                    ->options([
                        'presential' => 'Présentiel',
                        'online' => 'En ligne',
                        'hybrid' => 'Hybride',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Actif'),
            ])
            ->defaultSort('title')
            ->emptyStateIcon(Heroicon::OutlinedAcademicCap)
            ->emptyStateHeading('Aucune formation')
            ->emptyStateDescription('Créez votre première formation.')
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
