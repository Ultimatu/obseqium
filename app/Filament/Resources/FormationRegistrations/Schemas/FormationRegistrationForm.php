<?php

namespace App\Filament\Resources\FormationRegistrations\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class FormationRegistrationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)
            ->components([
                Section::make('Session & Participant')->description('Session concernée et coordonnées du participant.')->columns(['default' => 1, 'sm' => 2])->schema([
                    Select::make('formation_session_id')->label('Session')->relationship('session', 'start_date', fn ($q) => $q->with('formation'))->getOptionLabelFromRecordUsing(fn ($record) => $record->formation->title.' - '.($record->start_date?->format('d/m/Y') ?? ''))->searchable()->preload()->required()->columnSpanFull(),
                    Select::make('user_id')->label('Compte client')->relationship('user', 'name')->searchable()->preload()->nullable(),
                    TextInput::make('guest_name')->label('Nom (invité)')->prefixIcon(Heroicon::OutlinedUser),
                    TextInput::make('guest_email')->label('Email (invité)')->prefixIcon(Heroicon::OutlinedEnvelope)->email(),
                    TextInput::make('guest_phone')->label('Téléphone')->prefixIcon(Heroicon::OutlinedPhone)->tel(),
                    TextInput::make('guest_company')->label('Société')->prefixIcon(Heroicon::OutlinedBuildingOffice),
                ]),
                Section::make('Statut')->description('Suivi de l\'inscription et remise de l\'attestation.')->columns(['default' => 1, 'sm' => 2])->schema([
                    Select::make('status')->label('Statut')->required()->options([
                        'pending' => 'En attente', 'confirmed' => 'Confirmée', 'cancelled' => 'Annulée', 'completed' => 'Terminée',
                    ])->default('pending'),
                    DateTimePicker::make('confirmed_at')->label('Confirmée le'),
                    DateTimePicker::make('cancelled_at')->label('Annulée le'),
                    Textarea::make('notes')->label('Notes')->rows(2)->columnSpanFull(),
                    TextInput::make('attestation_path')->label('Chemin attestation PDF'),
                ]),
            ]);
    }
}
