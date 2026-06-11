<?php

namespace App\Filament\Resources\Newsletters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NewslettersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')->label('Email')->searchable()->sortable(),
                TextColumn::make('name')->label('Nom')->searchable()->placeholder('-'),
                IconColumn::make('is_active')->label('Actif')->boolean(),
                TextColumn::make('subscribed_at')->label('Inscrit le')->date('d/m/Y')->sortable(),
                TextColumn::make('unsubscribed_at')->label('Désinscrit le')->date('d/m/Y')->placeholder('-'),
            ])
            ->filters([TernaryFilter::make('is_active')->label('Actif')])
            ->defaultSort('subscribed_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedEnvelope)
            ->emptyStateHeading('Aucun abonné à la newsletter')
            ->emptyStateDescription('Les inscriptions à la newsletter apparaîtront ici.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
