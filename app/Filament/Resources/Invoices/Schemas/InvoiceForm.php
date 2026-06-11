<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)

            ->components([
                Section::make('Informations client')
                    ->description('Coordonnées du client facturé.')
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
                        TextInput::make('client_address')
                            ->label('Adresse')
                            ->prefixIcon(Heroicon::OutlinedMapPin)
                            ->columnSpanFull(),
                        Select::make('client_id')
                            ->label('Compte client lié')
                            ->relationship('client', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->nullable(),
                    ]),

                Section::make('Lignes de facture')
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
                                    ->label('Prix unitaire (FCFA)')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->addActionLabel('Ajouter une ligne')
                            ->reorderable()
                            ->cloneable(),
                    ]),

                Section::make('Conditions')
                    ->description('Statut, TVA, dates et assignation.')
                    ->columns(['default' => 1, 'sm' => 2, 'lg' => 3])
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->native(false)
                            ->required()
                            ->options([
                                'draft' => 'Brouillon',
                                'sent' => 'Envoyée',
                                'paid' => 'Payée',
                                'overdue' => 'En retard',
                                'cancelled' => 'Annulée',
                            ])
                            ->default('draft'),
                        TextInput::make('tax_rate')
                            ->label('TVA (%)')
                            ->numeric()
                            ->default(0)
                            ->suffix('%'),
                        DatePicker::make('issued_at')
                            ->label('Date d\'émission')
                            ->required()
                            ->default(now()),
                        DatePicker::make('due_at')
                            ->label('Échéance')
                            ->required()
                            ->default(now()->addDays(30)),
                        DatePicker::make('paid_at')
                            ->label('Date de paiement')
                            ->nullable(),
                        Select::make('assigned_to')
                            ->label('Responsable')
                            ->options(fn () => User::pluck('name', 'id'))
                            ->native(false)
                            ->searchable()
                            ->nullable(),
                        Select::make('quote_id')
                            ->label('Devis lié')
                            ->relationship('quote', 'reference')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->nullable(),
                    ]),

                Section::make('Totaux')
                    ->description('Calculés automatiquement depuis les lignes.')
                    ->columns(['default' => 1, 'sm' => 2, 'lg' => 3])
                    ->schema([
                        TextInput::make('subtotal')
                            ->label('Total HT')
                            ->readOnly()
                            ->dehydrated(false)
                            ->numeric()
                            ->suffix('FCFA')
                            ->placeholder('-'),
                        TextInput::make('tax_amount')
                            ->label('Montant TVA')
                            ->readOnly()
                            ->dehydrated(false)
                            ->numeric()
                            ->suffix('FCFA')
                            ->placeholder('-'),
                        TextInput::make('total')
                            ->label('Total TTC')
                            ->readOnly()
                            ->dehydrated(false)
                            ->numeric()
                            ->suffix('FCFA')
                            ->placeholder('-'),
                    ]),

                Section::make('Notes')
                    ->description('Observations complémentaires.')
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3),
                    ]),
            ]);
    }
}
