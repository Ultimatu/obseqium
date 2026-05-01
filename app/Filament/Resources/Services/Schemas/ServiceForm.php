<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Str;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informations')->description('Titre, description et positionnement du service.')->columns(['default' => 1, 'sm' => 2])->schema([
                TextInput::make('title')->label('Titre')->required()->live(onBlur: true)->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                    if (($get('slug') ?? '') !== Str::slug($old)) {
                        return;
                    }

                    $set('slug', Str::slug($state));
                })->columnSpanFull(),
                TextInput::make('slug')->label('Slug URL')->prefixIcon(Heroicon::OutlinedLink)->unique(ignoreRecord: true)->columnSpanFull(),
                TextInput::make('icon')->label('Icône (classe CSS)')->placeholder('heroicon-o-briefcase'),
                FileUpload::make('image')->label('Image')->image()->disk('public')->directory('services'),
                Select::make('type')->label('Type')->required()->options([
                    'strategic' => 'Accompagnement stratégique',
                    'audit' => 'Audit',
                    'qhse' => 'Conseil QHSE',
                    'training' => 'Formation',
                ])->default('qhse'),
                TextInput::make('order')->label('Ordre')->numeric()->default(0),
                Textarea::make('description')->label('Description courte')->required()->rows(3)->columnSpanFull(),
                RichEditor::make('content')->label('Contenu détaillé')->toolbarButtons(['bold','italic','h2','h3','bulletList','orderedList','link'])->columnSpanFull(),
            ]),
            Section::make('Méthodologie & Livrables')->description('Étapes d\'intervention et livrables attendus.')->columns(['default' => 1, 'sm' => 2])->schema([
                KeyValue::make('methodology')->label('Étapes de la méthodologie')->keyLabel('Étape')->valueLabel('Description')->addActionLabel('Ajouter une étape'),
                KeyValue::make('deliverables')->label('Livrables')->keyLabel('Livrable')->valueLabel('Détail')->addActionLabel('Ajouter un livrable'),
            ]),
            Section::make('SEO')->description('Visibilité sur le site et métadonnées de référencement.')->columns(['default' => 1, 'sm' => 2])->schema([
                Toggle::make('is_active')->label('Actif')->default(true)->inline(false),
                TextInput::make('meta_title')->label('Titre SEO')->prefixIcon(Heroicon::OutlinedMagnifyingGlass),
                Textarea::make('meta_description')->label('Description SEO')->rows(2)->columnSpanFull(),
            ]),
        ]);
    }
}