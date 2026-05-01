<?php

namespace App\Filament\Resources\FormationSessions;

use App\Filament\Resources\FormationSessions\Pages\CreateFormationSession;
use App\Filament\Resources\FormationSessions\Pages\EditFormationSession;
use App\Filament\Resources\FormationSessions\Pages\ListFormationSessions;
use App\Filament\Resources\FormationSessions\Schemas\FormationSessionForm;
use App\Filament\Resources\FormationSessions\Tables\FormationSessionsTable;
use App\Models\FormationSession;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormationSessionResource extends Resource
{
    protected static ?string $model = FormationSession::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static \UnitEnum|string|null $navigationGroup = 'Catalogue';

    protected static ?string $modelLabel = 'Session';

    protected static ?string $pluralModelLabel = 'Sessions';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return FormationSessionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormationSessionsTable::configure($table);
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
            'index' => ListFormationSessions::route('/'),
            'create' => CreateFormationSession::route('/create'),
            'edit' => EditFormationSession::route('/{record}/edit'),
        ];
    }
}
