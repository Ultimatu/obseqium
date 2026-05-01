<?php

namespace App\Filament\Resources\Testimonials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TestimonialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('author_avatar')->label('')->circular()->disk('public'),
                TextColumn::make('author_name')->label('Auteur')->searchable()->description(fn ($record) => $record->author_company),
                TextColumn::make('content')->label('Témoignage')->limit(80)->wrap(),
                TextColumn::make('rating')->label('Note')->formatStateUsing(fn ($state) => str_repeat('⭐', (int) $state)),
                IconColumn::make('is_featured')->label('Vedette')->boolean(),
                IconColumn::make('is_active')->label('Actif')->boolean(),
                TextColumn::make('order')->label('Ordre')->sortable(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->emptyStateIcon(Heroicon::OutlinedChatBubbleLeft)
            ->emptyStateHeading('Aucun témoignage')
            ->emptyStateDescription('Ajoutez les avis de vos clients.')
            ->recordActions([EditAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }
}