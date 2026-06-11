<?php

namespace App\Filament\Resources\References\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ReferenceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Client')->columns(2)->schema([
                    TextInput::make('title')->label('Titre de l\'étude de cas')->required()->live(onBlur: true)->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }

                        $set('slug', Str::slug($state));
                    })->columnSpanFull(),
                    TextInput::make('slug')->label('Slug URL')->unique(ignoreRecord: true)->columnSpanFull(),
                    TextInput::make('client_name')->label('Nom du client')->required(),
                    TextInput::make('sector')->label('Secteur')->required(),
                    FileUpload::make('client_logo')->label('Logo client')->image()->disk('public')->directory('references'),
                    FileUpload::make('cover_image')->label('Image de couverture')->image()->disk('public')->directory('references'),
                ]),
                Section::make('Contenu')->schema([
                    RichEditor::make('challenge')->label('Problématique')->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),
                    RichEditor::make('solution')->label('Solution apportée')->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),
                    RichEditor::make('results')->label('Résultats obtenus')->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList']),
                    KeyValue::make('key_figures')->label('Chiffres clés')->keyLabel('Indicateur')->valueLabel('Valeur')->addActionLabel('Ajouter un chiffre'),
                ]),
                Section::make('Options')->columns(2)->schema([
                    Toggle::make('show_client_name')->label('Afficher le nom du client')->default(true)->inline(false),
                    Toggle::make('is_featured')->label('Mise en avant')->inline(false),
                    Toggle::make('is_active')->label('Actif')->default(true)->inline(false),
                    TextInput::make('order')->label('Ordre')->numeric()->default(0),
                ]),
            ]);
    }
}
