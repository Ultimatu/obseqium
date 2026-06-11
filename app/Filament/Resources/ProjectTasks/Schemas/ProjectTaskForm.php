<?php

namespace App\Filament\Resources\ProjectTasks\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class ProjectTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->columns(1)->components([
            Tabs::make()->tabs([
                Tab::make('Informations')->schema([
                    Section::make()->columns(['default' => 1, 'sm' => 2])->schema([
                        TextInput::make('title')
                            ->label('Titre')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                        Select::make('project_id')
                            ->label('Projet')
                            ->relationship('project', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('assigned_to')
                            ->label('Assigné à')
                            ->options(User::query()->where('is_active', true)->pluck('name', 'id'))
                            ->searchable()
                            ->nullable()
                            ->default(Auth::id()),
                        Select::make('status')
                            ->label('Statut')
                            ->required()
                            ->options([
                                'todo' => 'À faire',
                                'in_progress' => 'En cours',
                                'done' => 'Terminé',
                            ])
                            ->default('todo'),
                        TextInput::make('weight')
                            ->label('Poids (1-10)')
                            ->helperText('Sert au calcul automatique de la progression du projet.')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(10)
                            ->default(1),
                        DatePicker::make('due_date')
                            ->label('Échéance')
                            ->displayFormat('d/m/Y'),
                        Toggle::make('requires_deliverable')
                            ->label('Livrable obligatoire')
                            ->helperText('Cette tâche attend un fichier livrable.')
                            ->default(false)
                            ->columnSpanFull(),
                    ]),
                ]),

                Tab::make('Checklist')->schema([
                    Repeater::make('checklists')
                        ->relationship()
                        ->label('')
                        ->schema([
                            TextInput::make('label')
                                ->label('Élément')
                                ->required()
                                ->columnSpan(3),
                            Toggle::make('is_completed')
                                ->label('Fait')
                                ->default(false)
                                ->inline(false),
                        ])
                        ->columns(4)
                        ->addActionLabel('Ajouter un élément')
                        ->reorderable('order')
                        ->defaultItems(0),
                ]),

                Tab::make('Sous-tâches')->schema([
                    Repeater::make('subtasks')
                        ->relationship()
                        ->label('')
                        ->schema([
                            TextInput::make('title')
                                ->label('Titre')
                                ->required()
                                ->columnSpan(2),
                            Select::make('assigned_to')
                                ->label('Assigné à')
                                ->options(User::query()->where('is_active', true)->pluck('name', 'id'))
                                ->searchable()
                                ->nullable(),
                            Select::make('status')
                                ->label('Statut')
                                ->options([
                                    'todo' => 'À faire',
                                    'in_progress' => 'En cours',
                                    'done' => 'Terminé',
                                ])
                                ->default('todo'),
                            TextInput::make('weight')
                                ->label('Poids')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(10)
                                ->default(1),
                        ])
                        ->columns(5)
                        ->addActionLabel('Ajouter une sous-tâche')
                        ->defaultItems(0),
                ]),

                Tab::make('Commentaires')->schema([
                    Repeater::make('comments')
                        ->relationship()
                        ->label('')
                        ->schema([
                            Select::make('user_id')
                                ->label('Auteur')
                                ->options(User::query()->where('is_active', true)->pluck('name', 'id'))
                                ->required()
                                ->default(Auth::id()),
                            Textarea::make('body')
                                ->label('Commentaire')
                                ->required()
                                ->rows(2),
                        ])
                        ->columns(1)
                        ->addActionLabel('Ajouter un commentaire')
                        ->defaultItems(0)
                        ->deletable(false),
                ]),
            ]),
        ]);
    }
}
