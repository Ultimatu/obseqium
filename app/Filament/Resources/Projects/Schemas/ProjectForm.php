<?php

namespace App\Filament\Resources\Projects\Schemas;

use App\Models\DiagnosticRequest;
use App\Models\Quote;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Projet')->columns(['default' => 1, 'sm' => 2])->schema([
                    TextInput::make('name')
                        ->label('Nom du projet')
                        ->prefixIcon(Heroicon::OutlinedFolderOpen)
                        ->required()
                        ->columnSpanFull(),
                    Textarea::make('description')
                        ->label('Description')
                        ->rows(3)
                        ->columnSpanFull(),
                    Select::make('status')
                        ->label('Statut')
                        ->required()
                        ->options([
                            'not_started' => 'Non démarré',
                            'active' => 'En cours',
                            'review' => 'En révision',
                            'completed' => 'Terminé',
                            'archived' => 'Archivé',
                        ])
                        ->default('not_started'),
                    Select::make('created_by')
                        ->label('Responsable')
                        ->relationship('creator', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

                Section::make('Origine')->description('Lier ce projet à un devis ou un audit existant (optionnel).')->columns(['default' => 1, 'sm' => 2])->schema([
                    Select::make('quote_id')
                        ->label('Devis associé')
                        ->options(Quote::query()->pluck('reference', 'id'))
                        ->searchable()
                        ->nullable(),
                    Select::make('diagnostic_request_id')
                        ->label('Audit associé')
                        ->options(DiagnosticRequest::query()->pluck('company_name', 'id'))
                        ->searchable()
                        ->nullable(),
                ]),

                Section::make('Calendrier')->columns(['default' => 1, 'sm' => 3])->schema([
                    DatePicker::make('start_date')
                        ->label('Date de début')
                        ->displayFormat('d/m/Y'),
                    DatePicker::make('due_date')
                        ->label('Date limite')
                        ->displayFormat('d/m/Y'),
                    DatePicker::make('completed_at')
                        ->label('Clôturé le')
                        ->displayFormat('d/m/Y'),
                ]),
            ]);
    }
}
