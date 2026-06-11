<?php

namespace App\Filament\Resources\HeroSlides\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class HeroSlideForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)
            ->components([
                Section::make('Contenu')->columns(['default' => 1, 'sm' => 2])->schema([
                    TextInput::make('badge')
                        ->label('Badge (petit texte au-dessus du titre)')
                        ->placeholder('Cabinet expert en QHSE')
                        ->prefixIcon(Heroicon::OutlinedTag)
                        ->columnSpanFull(),

                    TextInput::make('title')
                        ->label('Titre')
                        ->required()
                        ->prefixIcon(Heroicon::OutlinedDocumentText)
                        ->columnSpanFull(),

                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3)
                        ->columnSpanFull(),

                    FileUpload::make('image')
                        ->label('Image de fond (optionnel)')
                        ->image()
                        ->disk('public')
                        ->directory('hero')
                        ->hint('Si renseignée, remplace le dégradé')
                        ->columnSpanFull(),

                    Select::make('gradient')
                        ->label('Couleur de fond')
                        ->options([
                            'from-brand-950 via-brand-800 to-brand-600' => 'Vert principal',
                            'from-brand-950 via-brand-900 to-brand-700' => 'Vert foncé',
                            'from-brand-900 via-brand-700 to-emerald-600' => 'Vert émeraude',
                            'from-slate-900 via-slate-800 to-brand-800' => 'Ardoise + vert',
                            'from-brand-900 via-teal-800 to-teal-600' => 'Teal',
                        ])
                        ->default('from-brand-950 via-brand-800 to-brand-600')
                        ->native(false)
                        ->columnSpanFull(),
                ]),

                Section::make('Boutons d\'action')->columns(2)->schema([
                    TextInput::make('cta_primary_label')
                        ->label('Bouton principal - texte')
                        ->placeholder('Demander un devis gratuit'),

                    TextInput::make('cta_primary_href')
                        ->label('Bouton principal - lien')
                        ->placeholder('/devis')
                        ->prefixIcon(Heroicon::OutlinedLink),

                    TextInput::make('cta_secondary_label')
                        ->label('Bouton secondaire - texte')
                        ->placeholder('Découvrir nos services'),

                    TextInput::make('cta_secondary_href')
                        ->label('Bouton secondaire - lien')
                        ->placeholder('/services')
                        ->prefixIcon(Heroicon::OutlinedLink),
                ]),

                Section::make('Paramètres')->columns(2)->schema([
                    TextInput::make('order')
                        ->label('Ordre d\'affichage')
                        ->numeric()
                        ->default(0),

                    Toggle::make('is_active')
                        ->label('Slide active')
                        ->default(true)
                        ->inline(false),
                ]),
            ]);
    }
}
