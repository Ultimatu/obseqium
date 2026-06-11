<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Compte')->columns(['default' => 1, 'sm' => 2])->schema([
                    TextInput::make('name')->label('Nom complet')->prefixIcon(Heroicon::OutlinedUser)->required(),
                    TextInput::make('email')->label('Email')->prefixIcon(Heroicon::OutlinedEnvelope)->email()->required()->unique(ignoreRecord: true),
                    TextInput::make('phone')->label('Téléphone')->prefixIcon(Heroicon::OutlinedPhone)->tel(),
                    TextInput::make('job_title')->label('Fonction')->prefixIcon(Heroicon::OutlinedBriefcase),
                    Toggle::make('is_active')->label('Compte actif')->default(true)->inline(false),
                    TextInput::make('password')->label('Mot de passe')->password()->dehydrateStateUsing(fn ($state) => Hash::make($state))->dehydrated(fn ($state) => filled($state))->required(fn ($livewire) => $livewire instanceof CreateRecord)->columnSpanFull(),
                ]),
                Section::make('Profil public')->description('Affiché sur la page À propos.')->columns(['default' => 1, 'sm' => 2])->schema([
                    FileUpload::make('photo')->label('Photo')->image()->disk('public')->directory('team')->imageEditor()->columnSpanFull(),
                    Textarea::make('bio')->label('Biographie')->rows(3)->columnSpanFull(),
                    TextInput::make('linkedin_url')->label('LinkedIn')->url()->prefixIcon(Heroicon::OutlinedLink),
                    TextInput::make('order')->label('Ordre d\'affichage')->numeric()->default(0),
                ]),
            ]);
    }
}
