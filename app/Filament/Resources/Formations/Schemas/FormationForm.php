<?php

namespace App\Filament\Resources\Formations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FormationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)
            ->components([
                Section::make('Informations générales')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Intitulé')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            })
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug URL')
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        FileUpload::make('cover_image')
                            ->label('Image de couverture')
                            ->image()
                            ->disk('public')
                            ->directory('formations')
                            ->columnSpanFull(),
                        Select::make('thematic')
                            ->label('Thématique')
                            ->required()
                            ->options([
                                'qualite' => 'Qualité',
                                'securite' => 'Santé-Sécurité',
                                'environnement' => 'Environnement',
                                'reglementation' => 'Réglementation',
                                'management' => 'Management',
                            ])
                            ->default('qualite'),
                        Select::make('format')
                            ->label('Format')
                            ->required()
                            ->options([
                                'presential' => 'Présentiel',
                                'online' => 'En ligne',
                                'hybrid' => 'Hybride',
                            ])
                            ->default('presential'),
                        TextInput::make('duration_hours')
                            ->label('Durée (heures)')
                            ->required()
                            ->numeric()
                            ->suffix('h'),
                        TextInput::make('price')
                            ->label('Tarif (€)')
                            ->numeric()
                            ->prefix('€')
                            ->nullable(),
                        Toggle::make('price_on_request')
                            ->label('Prix sur demande')
                            ->inline(false),
                    ]),

                Section::make('Contenu pédagogique')
                    ->schema([
                        Textarea::make('description')
                            ->label('Présentation')
                            ->required()
                            ->rows(3),
                        RichEditor::make('objectives')
                            ->label('Objectifs pédagogiques')
                            ->toolbarButtons(['bold', 'bulletList', 'orderedList']),
                        RichEditor::make('program')
                            ->label('Programme')
                            ->toolbarButtons(['bold', 'bulletList', 'orderedList', 'h2', 'h3']),
                        Textarea::make('target_audience')
                            ->label('Public cible')
                            ->rows(2),
                        Textarea::make('prerequisites')
                            ->label('Prérequis')
                            ->rows(2),
                    ]),

                Section::make('SEO & Publication')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Actif')
                            ->default(true)
                            ->inline(false),
                        Toggle::make('is_featured')
                            ->label('Mise en avant')
                            ->inline(false),
                        TextInput::make('meta_title')
                            ->label('Titre SEO')
                            ->columnSpanFull(),
                        Textarea::make('meta_description')
                            ->label('Description SEO')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
