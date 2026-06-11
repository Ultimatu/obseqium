<?php

namespace App\Filament\Resources\Pricings\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PricingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identification')->schema([
                    TextInput::make('key')
                        ->label('Clé')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->default('default')
                        ->helperText('Utilisez "default" pour la page principale'),
                    Toggle::make('is_active')
                        ->label('Actif')
                        ->default(true),
                ])->columns(2),

                Section::make('Hero Section')->schema([
                    TextInput::make('hero_title')
                        ->label('Titre')
                        ->required(),
                    RichEditor::make('hero_description')
                        ->label('Description')
                        ->toolbarButtons(['bold', 'italic']),
                ]),

                Section::make('Principe de tarification')->schema([
                    TextInput::make('pricing_principle_title')
                        ->label('Titre'),
                    RichEditor::make('pricing_principle_content')
                        ->label('Contenu')
                        ->toolbarButtons(['bold', 'italic']),
                ]),

                Section::make('Critères de tarification (7 critères)')->schema([
                    Repeater::make('criteria')
                        ->label('Critères')
                        ->addActionLabel('Ajouter un critère')
                        ->schema([
                            TextInput::make('title')->label('Titre')->required(),
                            TextInput::make('description')->label('Description')->required(),
                        ])
                        ->defaultItems(7)
                        ->collapsible(),
                ]),

                Section::make('Exemple chiffré')->schema([
                    TextInput::make('example_total_amount')
                        ->label('Montant total (FCFA)')
                        ->numeric()
                        ->prefix('FCFA'),
                    TextInput::make('example_duration_months')
                        ->label('Durée (mois)')
                        ->numeric()
                        ->suffix('mois'),
                ])->columns(2),

                Section::make('Modalités de paiement')->schema([
                    RichEditor::make('payment_terms')
                        ->label('Conditions de paiement')
                        ->toolbarButtons(['bold', 'italic']),
                ]),

                Section::make('Inclusions / Exclusions')->schema([
                    KeyValue::make('includes')
                        ->label('Inclus dans l\'offre')
                        ->addActionLabel('Ajouter')
                        ->keyLabel('Élément')
                        ->valueLabel('Détail (optionnel)'),
                    KeyValue::make('excludes')
                        ->label('Exclusions')
                        ->addActionLabel('Ajouter')
                        ->keyLabel('Élément')
                        ->valueLabel('Détail (optionnel)'),
                ]),

                Section::make('Processus de commande (5 étapes)')->schema([
                    Repeater::make('process_steps')
                        ->label('Étapes')
                        ->addActionLabel('Ajouter une étape')
                        ->schema([
                            TextInput::make('title')->label('Titre')->required(),
                            TextInput::make('description')->label('Description')->required(),
                        ])
                        ->defaultItems(5)
                        ->collapsible(),
                ]),

                Section::make('Offre spéciale')->schema([
                    TextInput::make('offer_title')
                        ->label('Titre de l\'offre'),
                    RichEditor::make('offer_content')
                        ->label('Contenu de l\'offre')
                        ->toolbarButtons(['bold', 'italic']),
                ]),
            ]);
    }
}
