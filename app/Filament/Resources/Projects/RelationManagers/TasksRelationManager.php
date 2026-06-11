<?php

namespace App\Filament\Resources\Projects\RelationManagers;

use App\Models\ProjectTask;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $title = 'Tâches';

    protected static string|\BackedEnum|null $icon = Heroicon::OutlinedClipboardDocumentList;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->columns(['default' => 1, 'sm' => 2])->schema([
                TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(2)
                    ->columnSpanFull(),
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
                    ->helperText('Le poids sert au calcul automatique de la progression du projet.')
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
        ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label('Tâche')
                    ->searchable()
                    ->description(fn (ProjectTask $record) => $record->description
                        ? Str::limit($record->description, 60)
                        : null),
                TextColumn::make('assignee.name')
                    ->label('Assigné à')
                    ->placeholder('—'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'todo' => 'À faire',
                        'in_progress' => 'En cours',
                        'done' => 'Terminé',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'todo' => 'gray',
                        'in_progress' => 'warning',
                        'done' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('weight')
                    ->label('Poids')
                    ->badge()
                    ->color('info'),
                TextColumn::make('checklist_progress')
                    ->label('Checklist')
                    ->state(fn (ProjectTask $record): string => $record->checklists()->count() > 0
                        ? $record->checklist_progress.'%'
                        : '—')
                    ->badge()
                    ->color(fn (ProjectTask $record): string => match (true) {
                        $record->checklists()->count() === 0 => 'gray',
                        $record->checklist_progress >= 100 => 'success',
                        $record->checklist_progress >= 50 => 'warning',
                        default => 'gray',
                    }),
                IconColumn::make('requires_deliverable')
                    ->label('Livrable')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedPaperClip)
                    ->falseIcon(Heroicon::OutlinedMinus)
                    ->trueColor('warning')
                    ->falseColor('gray'),
                TextColumn::make('due_date')
                    ->label('Échéance')
                    ->date('d/m/Y')
                    ->color(fn (ProjectTask $record): ?string => $record->due_date && $record->due_date->isPast() && $record->status !== 'done'
                        ? 'danger'
                        : null),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'todo' => 'À faire',
                        'in_progress' => 'En cours',
                        'done' => 'Terminé',
                    ]),
                SelectFilter::make('assigned_to')
                    ->label('Assigné à')
                    ->relationship('assignee', 'name'),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentList)
            ->emptyStateHeading('Aucune tâche')
            ->emptyStateDescription('Ajoutez des tâches à ce projet.')
            ->recordActions([
                EditAction::make()
                    ->modalWidth('3xl')
                    ->before(function (array $data, ProjectTask $record, EditAction $action): void {
                        if (($data['status'] ?? null) !== 'done' || $record->status === 'done') {
                            return;
                        }

                        $checklists = $data['checklists'] ?? [];
                        $hasUnchecked = collect($checklists)->contains(fn ($item) => empty($item['is_completed']));

                        if ($hasUnchecked) {
                            Notification::make()
                                ->title('Checklist incomplète')
                                ->body('Tous les éléments de la checklist doivent être cochés avant de terminer cette tâche.')
                                ->danger()
                                ->send();
                            $action->halt();

                            return;
                        }

                        $requiresDeliverable = (bool) ($data['requires_deliverable'] ?? $record->requires_deliverable);

                        if ($requiresDeliverable && $record->deliverables()->count() === 0) {
                            Notification::make()
                                ->title('Livrable manquant')
                                ->body('Un livrable doit être fourni avant de terminer cette tâche.')
                                ->danger()
                                ->send();
                            $action->halt();
                        }
                    })
                    ->schema(fn (Schema $schema): Schema => $schema->components([
                        Tabs::make()->tabs([
                            Tab::make('Informations')->schema([
                                Section::make()->columns(['default' => 1, 'sm' => 2])->schema([
                                    TextInput::make('title')
                                        ->label('Titre')
                                        ->required()
                                        ->columnSpanFull(),
                                    Textarea::make('description')
                                        ->label('Description')
                                        ->rows(2)
                                        ->columnSpanFull(),
                                    Select::make('assigned_to')
                                        ->label('Assigné à')
                                        ->options(User::query()->where('is_active', true)->pluck('name', 'id'))
                                        ->searchable()
                                        ->nullable(),
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
                                        ->numeric()
                                        ->minValue(1)
                                        ->maxValue(10)
                                        ->default(1),
                                    DatePicker::make('due_date')
                                        ->label('Échéance')
                                        ->displayFormat('d/m/Y'),
                                    Toggle::make('requires_deliverable')
                                        ->label('Livrable obligatoire')
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
                        ])->columnSpanFull(),
                    ])),
                Action::make('markInProgress')
                    ->label('En cours')
                    ->icon(Heroicon::OutlinedPlay)
                    ->color('warning')
                    ->visible(fn (ProjectTask $record) => $record->status === 'todo')
                    ->action(fn (ProjectTask $record) => $record->update(['status' => 'in_progress'])),
                Action::make('markDone')
                    ->label('Terminer')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (ProjectTask $record) => $record->status !== 'done')
                    ->action(function (ProjectTask $record, Action $action): void {
                        if ($record->hasUncompletedChecklists()) {
                            Notification::make()
                                ->title('Checklist incomplète')
                                ->body('Tous les éléments de la checklist doivent être cochés avant de terminer cette tâche.')
                                ->danger()
                                ->send();
                            $action->halt();

                            return;
                        }

                        if ($record->isMissingRequiredDeliverable()) {
                            Notification::make()
                                ->title('Livrable manquant')
                                ->body('Un livrable doit être fourni avant de terminer cette tâche.')
                                ->danger()
                                ->send();
                            $action->halt();

                            return;
                        }

                        $record->update(['status' => 'done']);
                    }),
                Action::make('reopen')
                    ->label('Rouvrir')
                    ->icon(Heroicon::OutlinedArrowUturnLeft)
                    ->color('gray')
                    ->visible(fn (ProjectTask $record) => $record->status === 'done')
                    ->action(fn (ProjectTask $record) => $record->update(['status' => 'todo'])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make()->modalWidth('2xl'),
            ]);
    }
}
