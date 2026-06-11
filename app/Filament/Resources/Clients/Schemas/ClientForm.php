<?php

namespace App\Filament\Resources\Clients\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informations personnelles')->columns(2)->schema([
                TextInput::make('name')
                    ->label('Nom complet')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('phone')
                    ->label('Téléphone')
                    ->tel(),
            ]),
            Section::make('Entreprise')->columns(2)->schema([
                TextInput::make('company')
                    ->label('Société'),
                TextInput::make('job_title')
                    ->label('Fonction'),
                TextInput::make('sector')
                    ->label('Secteur d\'activité'),
            ]),
            Section::make('Localisation')->columns(2)->schema([
                TextInput::make('address')
                    ->label('Adresse')
                    ->columnSpanFull(),
                TextInput::make('city')
                    ->label('Ville'),
                Select::make('country')
                    ->label('Pays')
                    ->options([
                        'CI' => 'Côte d\'Ivoire',
                        'SN' => 'Sénégal',
                        'CM' => 'Cameroun',
                        'ML' => 'Mali',
                        'BF' => 'Burkina Faso',
                        'GN' => 'Guinée',
                        'TG' => 'Togo',
                        'BJ' => 'Bénin',
                        'FR' => 'France',
                    ])
                    ->default('CI'),
            ]),
            Section::make('Notes & Statut')->schema([
                Textarea::make('notes')
                    ->label('Notes internes')
                    ->rows(3),
                Toggle::make('is_active')
                    ->label('Client actif')
                    ->default(true)
                    ->inline(false),
            ]),
        ]);
    }
}
