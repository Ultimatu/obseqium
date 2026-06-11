<?php

namespace App\Filament\Resources\ProcessPhases;

use App\Filament\Resources\ProcessPhases\Pages\CreateProcessPhase;
use App\Filament\Resources\ProcessPhases\Pages\EditProcessPhase;
use App\Filament\Resources\ProcessPhases\Pages\ListProcessPhases;
use App\Filament\Resources\ProcessPhases\Schemas\ProcessPhaseForm;
use App\Filament\Resources\ProcessPhases\Tables\ProcessPhasesTable;
use App\Models\ProcessPhase;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class ProcessPhaseResource extends Resource
{
    protected static ?string $model = ProcessPhase::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Site Web';

    protected static ?string $navigationLabel = 'Processus';

    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return ProcessPhaseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProcessPhasesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProcessPhases::route('/'),
            'create' => CreateProcessPhase::route('/create'),
            'edit' => EditProcessPhase::route('/{record}/edit'),
        ];
    }
}
