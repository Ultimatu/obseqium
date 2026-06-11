<?php

namespace App\Filament\Resources\Appointments\Tables;

use App\Filament\Exports\AppointmentExporter;
use App\Models\Appointment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('requested_date')
                    ->label('Date demandée')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('requester.name')
                    ->label('Client')
                    ->searchable()
                    ->placeholder(fn ($record) => $record->guest_name),
                TextColumn::make('guest_name')
                    ->label('Invité')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('type')
                    ->label('Format')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'visio' ? 'Visio' : 'Présentiel')
                    ->color(fn ($state) => $state === 'visio' ? 'info' : 'warning'),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmé',
                        'cancelled' => 'Annulé',
                        'completed' => 'Effectué',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('consultant.name')
                    ->label('Consultant')
                    ->placeholder('Non assigné'),
                TextColumn::make('duration_minutes')
                    ->label('Durée')
                    ->suffix(' min'),
                TextColumn::make('confirmed_date')
                    ->label('Date confirmée')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('-'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmé',
                        'cancelled' => 'Annulé',
                        'completed' => 'Effectué',
                    ]),
                SelectFilter::make('type')
                    ->label('Format')
                    ->options(['visio' => 'Visio', 'presential' => 'Présentiel']),
            ])
            ->defaultSort('requested_date', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedCalendarDays)
            ->emptyStateHeading('Aucun rendez-vous')
            ->emptyStateDescription('Les demandes de rendez-vous apparaîtront ici.')
            ->recordActions([
                Action::make('confirm')
                    ->label('Confirmer')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (Appointment $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmer le rendez-vous')
                    ->action(fn (Appointment $record) => $record->update(['status' => 'confirmed'])),
                Action::make('cancel')
                    ->label('Annuler')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (Appointment $record) => in_array($record->status, ['pending', 'confirmed']))
                    ->requiresConfirmation()
                    ->modalHeading('Annuler le rendez-vous')
                    ->action(fn (Appointment $record) => $record->update(['status' => 'cancelled'])),
                Action::make('complete')
                    ->label('Effectué')
                    ->icon(Heroicon::OutlinedCheckBadge)
                    ->color('gray')
                    ->visible(fn (Appointment $record) => $record->status === 'confirmed')
                    ->requiresConfirmation()
                    ->modalHeading('Marquer comme effectué')
                    ->action(fn (Appointment $record) => $record->update(['status' => 'completed'])),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()->exporter(AppointmentExporter::class)->label('Exporter'),
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
