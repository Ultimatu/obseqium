<?php

namespace App\Filament\Resources\ProcessPhases\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProcessPhaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informations générales')->schema([
                    TextInput::make('order')
                        ->label('Ordre (1-9)')
                        ->numeric()
                        ->required()
                        ->default(1),
                    TextInput::make('title')
                        ->label('Titre de la phase')
                        ->required(),
                    TextInput::make('badge')
                        ->label('Badge (optionnel)')
                        ->placeholder('ex: GRATUIT')
                        ->helperText('Affiché en badge coloré sur la timeline'),
                    TextInput::make('icon')
                        ->label('Icône Heroicon')
                        ->placeholder('ex: clipboard-document-check')
                        ->helperText('Nom de l\'icône Heroicon (sans préfixe)'),
                    Toggle::make('is_active')
                        ->label('Actif')
                        ->default(true),
                ])->columns(2),

                Section::make('Contenu')->schema([
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(4)
                        ->required(),
                    Repeater::make('highlights')
                        ->label('Points clés (highlights)')
                        ->addActionLabel('Ajouter un point clé')
                        ->schema([
                            TextInput::make('highlight')
                                ->label('Point clé')
                                ->required(),
                        ])
                        ->defaultItems(3)
                        ->collapsible(),
                ]),
            ]);
    }
}
