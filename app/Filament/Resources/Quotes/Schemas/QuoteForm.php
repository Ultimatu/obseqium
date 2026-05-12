<?php

namespace App\Filament\Resources\Quotes\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations client')
                    ->description('Coordonnées du destinataire du devis.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Nom complet')
                            ->prefixIcon(Heroicon::OutlinedUser)
                            ->required(),
                        TextInput::make('client_email')
                            ->label('Email')
                            ->prefixIcon(Heroicon::OutlinedEnvelope)
                            ->email()
                            ->required(),
                        TextInput::make('client_phone')
                            ->label('Téléphone')
                            ->prefixIcon(Heroicon::OutlinedPhone)
                            ->tel(),
                        TextInput::make('client_company')
                            ->label('Société')
                            ->prefixIcon(Heroicon::OutlinedBuildingOffice),
                        TextInput::make('client_job_title')
                            ->label('Fonction')
                            ->prefixIcon(Heroicon::OutlinedBriefcase),
                        Select::make('client_id')
                            ->label('Compte client lié')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->nullable(),
                    ]),

                Section::make('Prestation')
                    ->description('Nature et contexte de la mission demandée.')
                    ->columns(['default' => 1, 'sm' => 2])
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
                            ])->native(false)
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
                    ->description('Détaillez chaque prestation, quantité et tarif unitaire.')
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
                    ->description('TVA, délai de validité et responsable du dossier.')
                    ->columns(['default' => 1, 'sm' => 2, 'lg' => 3])
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->native(false)
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
                            ->options(fn () => User::consultants()->pluck('name', 'id'))
                            ->native(false)
                            ->searchable()
                            ->nullable(),
                    ]),

                Section::make('Récapitulatif')
                    ->description('Totaux calculés automatiquement à partir des lignes.')
                    ->columns(['default' => 1, 'sm' => 2, 'lg' => 3])
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('Total HT')
                            ->readOnly()
                            ->dehydrated(false)
                            ->numeric()
                            ->prefix('€')
                            ->placeholder('—'),
                        TextInput::make('tax_amount')
                            ->label('Montant TVA')
                            ->readOnly()
                            ->dehydrated(false)
                            ->numeric()
                            ->prefix('€')
                            ->placeholder('—'),
                        TextInput::make('total')
                            ->label('Total TTC')
                            ->readOnly()
                            ->dehydrated(false)
                            ->numeric()
                            ->prefix('€')
                            ->placeholder('—'),
                    ]),

                Section::make('Notes')
                    ->description('Observations destinées au client et notes internes.')
                    ->columns(['default' => 1, 'sm' => 2])
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
