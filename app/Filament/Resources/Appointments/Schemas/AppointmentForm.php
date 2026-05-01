<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Demandeur')
                    ->description('Associez un compte existant ou saisissez les coordonnées d\'un contact invité.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Select::make('requester_id')
                            ->label('Compte client lié')
                            ->relationship('requester', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('consultant_id')
                            ->label('Consultant assigné')
                            ->options(fn () => User::consultants()->pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),
                        TextInput::make('guest_name')
                            ->label('Nom (invité)')
                            ->prefixIcon(Heroicon::OutlinedUser)
                            ->requiredWithout('requester_id'),
                        TextInput::make('guest_email')
                            ->label('Email (invité)')
                            ->prefixIcon(Heroicon::OutlinedEnvelope)
                            ->email(),
                        TextInput::make('guest_phone')
                            ->label('Téléphone')
                            ->prefixIcon(Heroicon::OutlinedPhone)
                            ->tel(),
                        TextInput::make('guest_company')
                            ->label('Société')
                            ->prefixIcon(Heroicon::OutlinedBuildingOffice),
                    ]),

                Section::make('Rendez-vous')
                    ->description('Planification, format et logistique du rendez-vous.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Select::make('type')
                            ->label('Format')
                            ->required()
                            ->options(['visio' => 'Visioconférence', 'presential' => 'Présentiel'])
                            ->default('visio')
                            ->live(),
                        Select::make('status')
                            ->label('Statut')
                            ->required()
                            ->options([
                                'pending' => 'En attente',
                                'confirmed' => 'Confirmé',
                                'cancelled' => 'Annulé',
                                'completed' => 'Effectué',
                            ])
                            ->default('pending'),
                        DateTimePicker::make('requested_date')
                            ->label('Date demandée')
                            ->required(),
                        DateTimePicker::make('confirmed_date')
                            ->label('Date confirmée'),
                        TextInput::make('duration_minutes')
                            ->label('Durée (min)')
                            ->numeric()
                            ->default(60)
                            ->suffix('min'),
                        TextInput::make('meeting_link')
                            ->label('Lien visio')
                            ->prefixIcon(Heroicon::OutlinedVideoCamera)
                            ->url()
                            ->visible(fn (Get $get): bool => $get('type') === 'visio'),
                        TextInput::make('location')
                            ->label('Lieu')
                            ->prefixIcon(Heroicon::OutlinedMapPin)
                            ->columnSpanFull()
                            ->visible(fn (Get $get): bool => $get('type') === 'presential'),
                        Textarea::make('subject')
                            ->label('Objet')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->label('Notes internes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
