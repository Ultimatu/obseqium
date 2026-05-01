<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Profil')->description('Compte utilisateur et droits d\'accès.')->columns(['default' => 1, 'sm' => 2])->schema([
                TextInput::make('name')->label('Nom complet')->prefixIcon(Heroicon::OutlinedUser)->required(),
                TextInput::make('email')->label('Email')->prefixIcon(Heroicon::OutlinedEnvelope)->email()->required()->unique(ignoreRecord: true),
                TextInput::make('phone')->label('Téléphone')->prefixIcon(Heroicon::OutlinedPhone)->tel(),
                TextInput::make('company')->label('Société')->prefixIcon(Heroicon::OutlinedBuildingOffice),
                TextInput::make('job_title')->label('Fonction')->prefixIcon(Heroicon::OutlinedBriefcase),
                Select::make('role')->label('Rôle')->required()->options([
                    'client' => 'Client', 'consultant' => 'Consultant', 'admin' => 'Administrateur',
                ])->default('client'),
                Toggle::make('is_active')->label('Compte actif')->default(true)->inline(false),
                TextInput::make('password')->label('Mot de passe')->password()->dehydrateStateUsing(fn ($state) => Hash::make($state))->dehydrated(fn ($state) => filled($state))->required(fn ($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)->columnSpanFull(),
            ]),
        ]);
    }
}