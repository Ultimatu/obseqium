<?php

namespace App\Filament\Resources\TeamMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TeamMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')->label('')->circular()->disk('public'),
                TextColumn::make('name')->label('Nom')->searchable()->sortable(),
                TextColumn::make('role')->label('Fonction')->searchable(),
                TextColumn::make('email')->label('Email')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('order')->label('Ordre')->numeric()->sortable(),
                IconColumn::make('is_active')->label('Actif')->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->emptyStateIcon(Heroicon::OutlinedUsers)
            ->emptyStateHeading('Aucun membre de l\'équipe')
            ->emptyStateDescription('Présentez les membres de votre équipe.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}