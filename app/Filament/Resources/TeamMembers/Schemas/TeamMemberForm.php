<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Membre de l\'équipe')->description('Profil et coordonnées du collaborateur.')->columns(['default' => 1, 'sm' => 2])->schema([
                TextInput::make('name')->label('Nom complet')->prefixIcon(Heroicon::OutlinedUser)->required(),
                TextInput::make('role')->label('Fonction')->prefixIcon(Heroicon::OutlinedBriefcase)->required(),
                FileUpload::make('photo')->label('Photo')->image()->disk('public')->directory('team')->imageEditor()->columnSpanFull(),
                Textarea::make('bio')->label('Biographie')->rows(4)->columnSpanFull(),
                TextInput::make('linkedin_url')->label('LinkedIn')->url()->prefixIcon(Heroicon::OutlinedLink)->prefix('https://'),
                TextInput::make('email')->label('Email professionnel')->prefixIcon(Heroicon::OutlinedEnvelope)->email(),
                TextInput::make('order')->label('Ordre d\'affichage')->numeric()->default(0),
                Toggle::make('is_active')->label('Visible sur le site')->default(true)->inline(false),
            ]),
        ]);
    }
}