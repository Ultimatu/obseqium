<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations personnelles')
                    ->description('Vos coordonnées et informations professionnelles.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        $this->getNameFormComponent()
                            ->prefixIcon(Heroicon::OutlinedUser),
                        $this->getEmailFormComponent()
                            ->prefixIcon(Heroicon::OutlinedEnvelope),
                        TextInput::make('phone')
                            ->label('Téléphone')
                            ->prefixIcon(Heroicon::OutlinedPhone)
                            ->tel(),
                        TextInput::make('company')
                            ->label('Société')
                            ->prefixIcon(Heroicon::OutlinedBuildingOffice),
                        TextInput::make('job_title')
                            ->label('Fonction')
                            ->prefixIcon(Heroicon::OutlinedBriefcase)
                            ->columnSpanFull(),
                    ]),

                Section::make('Sécurité')
                    ->description('Modifiez votre mot de passe. Laissez vide pour ne pas le changer.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]),
            ]);
    }
}
