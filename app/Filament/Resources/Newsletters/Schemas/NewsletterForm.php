<?php

namespace App\Filament\Resources\Newsletters\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NewsletterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('email')->label('Email')->email()->required(),
            TextInput::make('name')->label('Prénom / Nom'),
            Toggle::make('is_active')->label('Actif')->default(true)->inline(false),
            DateTimePicker::make('subscribed_at')->label('Inscrit le')->disabled(),
            DateTimePicker::make('unsubscribed_at')->label('Désinscrit le')->disabled(),
        ]);
    }
}