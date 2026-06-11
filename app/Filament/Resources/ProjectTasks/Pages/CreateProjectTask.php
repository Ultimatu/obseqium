<?php

namespace App\Filament\Resources\ProjectTasks\Pages;

use App\Filament\Resources\ProjectTasks\ProjectTaskResource;
use App\Filament\Resources\ProjectTasks\Schemas\ProjectTaskForm;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Schema;

class CreateProjectTask extends CreateRecord
{
    protected static string $resource = ProjectTaskResource::class;

    public function form(Schema $schema): Schema
    {
        return ProjectTaskForm::configure($schema);
    }
}
