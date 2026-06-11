<?php

namespace App\Filament\Resources\Contacts\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Coordonnées')
                    ->description('Informations transmises via le formulaire de contact.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->prefixIcon(Heroicon::OutlinedUser)
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->prefixIcon(Heroicon::OutlinedEnvelope)
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->label('Téléphone')
                            ->prefixIcon(Heroicon::OutlinedPhone)
                            ->tel(),
                        TextInput::make('company')
                            ->label('Société')
                            ->prefixIcon(Heroicon::OutlinedBuildingOffice),
                        TextInput::make('subject')
                            ->label('Objet')
                            ->prefixIcon(Heroicon::OutlinedChatBubbleLeft)
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('message')
                            ->label('Message')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Section::make('Traitement')
                    ->description('Suivi interne et assignation de la demande.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Toggle::make('is_read')
                            ->label('Lu')
                            ->inline(false),
                        Select::make('assigned_to')
                            ->label('Assigné à')
                            ->options(fn () => User::pluck('name', 'id'))
                            ->nullable(),
                        Textarea::make('admin_notes')
                            ->label('Notes internes')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
