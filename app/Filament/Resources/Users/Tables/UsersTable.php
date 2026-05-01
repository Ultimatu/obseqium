<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable()->sortable()->description(fn ($record) => $record->company),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone')->label('Téléphone')->placeholder('—'),
                TextColumn::make('role')->label('Rôle')->badge()->formatStateUsing(fn ($state) => match ($state) {
                    'client' => 'Client', 'consultant' => 'Consultant', 'admin' => 'Admin', default => $state,
                })->color(fn ($state) => match ($state) {
                    'client' => 'info', 'consultant' => 'warning', 'admin' => 'danger', default => 'gray',
                }),
                IconColumn::make('is_active')->label('Actif')->boolean(),
                TextColumn::make('created_at')->label('Créé le')->date('d/m/Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')->label('Rôle')->options(['client' => 'Client', 'consultant' => 'Consultant', 'admin' => 'Admin']),
                TernaryFilter::make('is_active')->label('Actif'),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedUsers)
            ->emptyStateHeading('Aucun utilisateur')
            ->emptyStateDescription('Les comptes utilisateurs apparaîtront ici.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}