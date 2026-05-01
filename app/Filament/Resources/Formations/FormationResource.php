<?php

namespace App\Filament\Resources\Formations;

use App\Filament\Resources\Formations\Pages\CreateFormation;
use App\Filament\Resources\Formations\Pages\EditFormation;
use App\Filament\Resources\Formations\Pages\ListFormations;
use App\Filament\Resources\Formations\Schemas\FormationForm;
use App\Filament\Resources\Formations\Tables\FormationsTable;
use App\Models\Formation;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormationResource extends Resource
{
    protected static ?string $model = Formation::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static \UnitEnum|string|null $navigationGroup = 'Catalogue';

    protected static ?string $modelLabel = 'Formation';

    protected static ?string $pluralModelLabel = 'Formations';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Thématique' => match ($record->thematic) {
                'qualite' => 'Qualité',
                'securite' => 'Sécurité',
                'environnement' => 'Environnement',
                'reglementation' => 'Réglementation',
                'management' => 'Management',
                default => $record->thematic,
            },
            'Durée' => $record->duration_hours.'h',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return FormationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFormations::route('/'),
            'create' => CreateFormation::route('/create'),
            'edit' => EditFormation::route('/{record}/edit'),
        ];
    }
}
