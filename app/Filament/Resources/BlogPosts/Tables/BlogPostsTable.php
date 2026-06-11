<?php

namespace App\Filament\Resources\BlogPosts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BlogPostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_image')->label('')->disk('public'),
                TextColumn::make('title')->label('Titre')->searchable()->wrap()->description(fn ($record) => $record->category?->name),
                TextColumn::make('author.name')->label('Auteur'),
                TextColumn::make('status')->label('Statut')->badge()->formatStateUsing(fn ($state) => match ($state) {
                    'draft' => 'Brouillon', 'published' => 'Publié', 'archived' => 'Archivé', default => $state,
                })->color(fn ($state) => match ($state) {
                    'draft' => 'gray', 'published' => 'success', 'archived' => 'warning', default => 'gray',
                }),
                TextColumn::make('published_at')->label('Publié le')->date('d/m/Y')->sortable()->placeholder('-'),
                TextColumn::make('views')->label('Vues')->numeric()->sortable(),
                IconColumn::make('is_featured')->label('À la une')->boolean(),
            ])
            ->filters([SelectFilter::make('status')->label('Statut')->options(['draft' => 'Brouillon', 'published' => 'Publié', 'archived' => 'Archivé'])])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedNewspaper)
            ->emptyStateHeading('Aucun article')
            ->emptyStateDescription('Créez votre premier article de blog.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}
