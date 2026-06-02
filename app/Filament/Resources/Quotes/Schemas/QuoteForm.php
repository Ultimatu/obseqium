<?php

namespace App\Filament\Resources\Quotes\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations client')
                    ->columns(2)
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Nom complet')
                            ->required(),
                        TextInput::make('client_email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        TextInput::make('client_phone')
                            ->label('Téléphone')
                            ->tel(),
                        TextInput::make('client_company')
                            ->label('Société'),
                        TextInput::make('client_job_title')
                            ->label('Fonction'),
                        Select::make('client_id')
                            ->label('Compte client lié')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                    ]),

                Section::make('Prestation')
                    ->columns(2)
                    ->schema([
                        Select::make('service_type')
                            ->label('Type de prestation')
                            ->required()
                            ->options([
                                'strategic' => 'Accompagnement stratégique',
                                'audit' => 'Audit',
                                'qhse' => 'Conseil QHSE',
                                'training' => 'Formation',
                                'other' => 'Autre',
                            ])
                            ->default('qhse'),
                        TextInput::make('sector')
                            ->label('Secteur d\'activité'),
                        TextInput::make('company_size')
                            ->label('Taille de l\'entreprise'),
                        DatePicker::make('deadline')
                            ->label('Échéance souhaitée'),
                        Textarea::make('description')
                            ->label('Description du besoin')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),

                Section::make('Lignes du devis')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->label('')
                            ->columns(5)
                            ->schema([
                                TextInput::make('description')
                                    ->label('Désignation')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('quantity')
                                    ->label('Qté')
                                    ->numeric()
                                    ->default(1)
                                    ->required(),
                                TextInput::make('unit')
                                    ->label('Unité')
                                    ->default('forfait'),
                                TextInput::make('unit_price')
                                    ->label('Prix unitaire (€)')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->addActionLabel('Ajouter une ligne')
                            ->reorderable()
                            ->cloneable(),
                    ]),

                Section::make('Conditions financières')
                    ->columns(3)
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->required()
                            ->options([
                                'draft' => 'Brouillon',
                                'sent' => 'Envoyé',
                                'viewed' => 'Consulté',
                                'accepted' => 'Accepté',
                                'refused' => 'Refusé',
                                'revision_requested' => 'Révision demandée',
                            ])
                            ->default('draft'),
                        TextInput::make('tax_rate')
                            ->label('TVA (%)')
                            ->numeric()
                            ->default(20)
                            ->suffix('%'),
                        DatePicker::make('valid_until')
                            ->label('Valable jusqu\'au'),
                        Select::make('assigned_to')
                            ->label('Consultant assigné')
                            ->options(fn () => User::where('role', '!=', 'client')->pluck('name', 'id'))
                            ->searchable()
                            ->nullable(),
                    ]),

                Section::make('Notes')
                    ->columns(2)
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes client')
                            ->rows(3),
                        Textarea::make('internal_notes')
                            ->label('Notes internes')
                            ->rows(3),
                    ]),
            ]);
    }
}
