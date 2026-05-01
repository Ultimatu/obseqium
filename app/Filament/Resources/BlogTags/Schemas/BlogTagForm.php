<?php

namespace App\Filament\Resources\BlogTags\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BlogTagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->label('Nom')->required(),
            TextInput::make('slug')->label('Slug URL')->unique(ignoreRecord: true),
        ]);
    }
}