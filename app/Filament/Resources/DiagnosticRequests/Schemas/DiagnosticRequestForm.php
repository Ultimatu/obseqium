<?php

namespace App\Filament\Resources\DiagnosticRequests\Schemas;

use App\Models\User;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class DiagnosticRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Client')
                    ->description('Informations sur l\'organisation demandeuse.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        TextInput::make('client_name')
                            ->label('Nom du contact')
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
                        Textarea::make('client_address')
                            ->label('Adresse')
                            ->columnSpanFull(),
                    ]),

                Section::make('Profil')
                    ->description('Secteur d\'activité et taille de l\'entreprise.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        TextInput::make('sector')
                            ->label('Secteur d\'activité')
                            ->prefixIcon(Heroicon::OutlinedBriefcase),
                        Select::make('company_size')
                            ->label('Taille de l\'entreprise')
                            ->native(false)
                            ->options([
                                'micro' => 'Micro-entreprise (< 10 pers.)',
                                'small' => 'Petite entreprise (10-49 pers.)',
                                'medium' => 'Moyenne entreprise (50-249 pers.)',
                                'large' => 'Grande entreprise (≥ 250 pers.)',
                            ]),
                        CheckboxList::make('requested_standards')
                            ->label('Normes ISO demandées')
                            ->options([
                                'ISO 9001' => 'ISO 9001 - Management de la Qualité',
                                'ISO 14001' => 'ISO 14001 - Management Environnemental',
                                'ISO 45001' => 'ISO 45001 - Santé et Sécurité au Travail',
                                'ISO 22000' => 'ISO 22000 - Sécurité des Denrées Alimentaires',
                                'ISO 27001' => 'ISO 27001 - Sécurité de l\'Information',
                            ])
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),

                Section::make('Planification')
                    ->description('Dates et assignation du consultant.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        DatePicker::make('requested_date')
                            ->label('Date souhaitée par le client'),
                        DatePicker::make('scheduled_date')
                            ->label('Date planifiée'),
                        DatePicker::make('completed_date')
                            ->label('Date de réalisation'),
                        Select::make('assigned_to')
                            ->label('Consultant assigné')
                            ->options(fn () => User::consultants()->pluck('name', 'id'))
                            ->searchable()
                            ->native(false)
                            ->nullable(),
                    ]),

                Section::make('Statut & Conversion')
                    ->description('Avancement et lien vers le devis.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Select::make('status')
                            ->label('Statut')
                            ->native(false)
                            ->required()
                            ->options([
                                'requested' => 'Demandé',
                                'scheduled' => 'Planifié',
                                'in_progress' => 'En cours',
                                'completed' => 'Terminé',
                                'cancelled' => 'Annulé',
                                'converted' => 'Converti en devis',
                            ]),
                        Select::make('converted_to_quote_id')
                            ->label('Devis lié')
                            ->relationship('quote', 'reference')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->nullable()
                            ->visible(fn ($get) => in_array($get('status'), ['completed', 'converted'])),
                    ]),

                Section::make('Résultats du diagnostic')
                    ->description('Rapport et évaluation des écarts.')
                    ->visible(fn ($get) => in_array($get('status'), ['completed', 'converted']))
                    ->schema([
                        FileUpload::make('report_path')
                            ->label('Rapport PDF')
                            ->disk('public')
                            ->directory('diagnostics')
                            ->acceptedFileTypes(['application/pdf'])
                            ->maxSize(10240)
                            ->downloadable(),
                        Select::make('overall_gap_level')
                            ->label('Niveau global des écarts')
                            ->native(false)
                            ->options([
                                'low' => 'Faible (structure déjà mature)',
                                'medium' => 'Moyen (ajustements nécessaires)',
                                'high' => 'Élevé (accompagnement complet requis)',
                            ]),
                        Textarea::make('gaps_identified')
                            ->label('Écarts identifiés')
                            ->rows(4)
                            ->placeholder('Décrivez les principaux écarts constatés...'),
                        Textarea::make('recommendations')
                            ->label('Recommandations')
                            ->rows(4)
                            ->placeholder('Préconisations pour l\'accompagnement...'),
                    ]),

                Section::make('Notes')
                    ->description('Observations internes et notes client.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Textarea::make('notes')
                            ->label('Notes client')
                            ->rows(3)
                            ->columnSpan(1),
                        Textarea::make('internal_notes')
                            ->label('Notes internes')
                            ->rows(3)
                            ->columnSpan(1),
                    ]),
            ]);
    }
}
