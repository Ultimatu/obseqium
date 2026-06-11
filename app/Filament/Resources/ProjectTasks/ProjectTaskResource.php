<?php

namespace App\Filament\Resources\ProjectTasks;

use App\Filament\Resources\ProjectTasks\Pages\CreateProjectTask;
use App\Filament\Resources\ProjectTasks\Pages\EditProjectTask;
use App\Filament\Resources\ProjectTasks\Pages\ListProjectTasks;
use App\Filament\Resources\ProjectTasks\Schemas\ProjectTaskForm;
use App\Filament\Resources\ProjectTasks\Tables\ProjectTasksTable;
use App\Models\ProjectTask;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProjectTaskResource extends Resource
{
    protected static ?string $model = ProjectTask::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Projets';

    protected static ?string $modelLabel = 'Tâche';

    protected static ?string $pluralModelLabel = 'Tâches';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'in_progress')->whereNull('parent_id')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Tâches en cours';
    }

    public static function form(Schema $schema): Schema
    {
        return ProjectTaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectTasksTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjectTasks::route('/'),
            'create' => CreateProjectTask::route('/create'),
            'edit' => EditProjectTask::route('/{record}/edit'),
        ];
    }
}
