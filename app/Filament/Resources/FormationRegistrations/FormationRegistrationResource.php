<?php

namespace App\Filament\Resources\FormationRegistrations;

use App\Filament\Resources\FormationRegistrations\Pages\CreateFormationRegistration;
use App\Filament\Resources\FormationRegistrations\Pages\EditFormationRegistration;
use App\Filament\Resources\FormationRegistrations\Pages\ListFormationRegistrations;
use App\Filament\Resources\FormationRegistrations\Schemas\FormationRegistrationForm;
use App\Filament\Resources\FormationRegistrations\Tables\FormationRegistrationsTable;
use App\Models\FormationRegistration;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FormationRegistrationResource extends Resource
{
    protected static ?string $model = FormationRegistration::class;

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static \UnitEnum|string|null $navigationGroup = 'Catalogue';

    protected static ?string $modelLabel = 'Inscription';

    protected static ?string $pluralModelLabel = 'Inscriptions';

    protected static ?int $navigationSort = 3;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'pending')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Inscriptions en attente de confirmation';
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        $participant = $record->guest_name ?? $record->user?->name ?? 'Participant';
        $formation = $record->session?->formation?->title ?? 'Formation';

        return $participant.' — '.$formation;
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Session' => $record->session?->start_date?->format('d/m/Y') ?? '—',
            'Statut' => match ($record->status) {
                'pending' => 'En attente',
                'confirmed' => 'Confirmée',
                'cancelled' => 'Annulée',
                'completed' => 'Terminée',
                default => $record->status,
            },
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['session.formation', 'user']);
    }

    public static function form(Schema $schema): Schema
    {
        return FormationRegistrationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FormationRegistrationsTable::configure($table);
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
            'index' => ListFormationRegistrations::route('/'),
            'create' => CreateFormationRegistration::route('/create'),
            'edit' => EditFormationRegistration::route('/{record}/edit'),
        ];
    }
}
