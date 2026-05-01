<?php

namespace App\Filament\Resources\BlogCategories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class BlogCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Catégorie')->description('Nom, couleur et ordre d\'affichage de la catégorie.')->columns(['default' => 1, 'sm' => 2])->schema([
                TextInput::make('name')->label('Nom')->prefixIcon(Heroicon::OutlinedTag)->required(),
                TextInput::make('slug')->label('Slug URL')->prefixIcon(Heroicon::OutlinedLink)->unique(ignoreRecord: true),
                ColorPicker::make('color')->label('Couleur')->default('#1a7a4a'),
                TextInput::make('order')->label('Ordre')->prefixIcon(Heroicon::OutlinedHashtag)->numeric()->default(0),
                Textarea::make('description')->label('Description')->rows(2)->columnSpanFull(),
            ]),
        ]);
    }
}