<?php

namespace App\Filament\Resources\FormationSessions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FormationSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)
            ->components([
                Section::make('Session')->description('Dates, lieu, capacité et statut de la session.')->columns(['default' => 1, 'sm' => 2])->schema([
                    Select::make('formation_id')->label('Formation')->relationship('formation', 'title')->searchable()->preload()->required()->columnSpanFull()->native(false),
                    DatePicker::make('start_date')->label('Date de début')->required(),
                    DatePicker::make('end_date')->label('Date de fin')->required()->afterOrEqual('start_date'),
                    TextInput::make('location')->label('Lieu / Salle')->prefixIcon(Heroicon::OutlinedBuildingOffice),
                    TextInput::make('city')->label('Ville')->prefixIcon(Heroicon::OutlinedMapPin),
                    TextInput::make('max_participants')->label('Places maximum')->numeric()->default(10)->required(),
                    TextInput::make('current_participants')->label('Inscrits actuels')->numeric()->default(0)->disabled(),
                    Select::make('status')->label('Statut')->required()->options([
                        'open' => 'Ouverte', 'full' => 'Complète', 'cancelled' => 'Annulée', 'completed' => 'Terminée',
                    ])->default('open')->native(false),
                    Toggle::make('is_published')->label('Publiée sur le site')->default(true)->inline(false),
                    Textarea::make('notes')->label('Notes internes')->rows(2)->columnSpanFull(),
                ]),
            ]);
    }
}
