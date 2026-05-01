<?php

namespace App\Filament\Resources\BlogTags\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BlogTagsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable()->sortable(),
                TextColumn::make('slug')->label('Slug'),
                TextColumn::make('posts_count')->label('Articles')->counts('posts')->badge(),
            ])
            ->defaultSort('name')
            ->emptyStateIcon(Heroicon::OutlinedHashtag)
            ->emptyStateHeading('Aucun tag')
            ->emptyStateDescription('Ajoutez des tags pour organiser vos articles.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}