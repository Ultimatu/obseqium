<?php

namespace App\Filament\Resources\DiagnosticRequests;

use App\Filament\Resources\DiagnosticRequests\Pages\CalendarDiagnosticRequests;
use App\Filament\Resources\DiagnosticRequests\Pages\CreateDiagnosticRequest;
use App\Filament\Resources\DiagnosticRequests\Pages\EditDiagnosticRequest;
use App\Filament\Resources\DiagnosticRequests\Pages\ListDiagnosticRequests;
use App\Filament\Resources\DiagnosticRequests\Schemas\DiagnosticRequestForm;
use App\Filament\Resources\DiagnosticRequests\Tables\DiagnosticRequestsTable;
use App\Models\DiagnosticRequest;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class DiagnosticRequestResource extends Resource
{
    protected static ?string $model = DiagnosticRequest::class;

    protected static \UnitEnum|string|null $navigationGroup = 'Commercial';

    protected static ?string $modelLabel = 'Diagnostic';

    protected static ?string $pluralModelLabel = 'Diagnostics';

    protected static ?int $navigationSort = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::pending()->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Diagnostics en attente';
    }

    public static function form(Schema $schema): Schema
    {
        return DiagnosticRequestForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DiagnosticRequestsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDiagnosticRequests::route('/'),
            'calendar' => CalendarDiagnosticRequests::route('/calendrier'),
            'create' => CreateDiagnosticRequest::route('/create'),
            'edit' => EditDiagnosticRequest::route('/{record}/edit'),
        ];
    }
}
