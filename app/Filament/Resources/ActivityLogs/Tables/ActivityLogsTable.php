<?php

namespace App\Filament\Resources\ActivityLogs\Tables;

use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ActivityLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

                TextColumn::make('action')
                    ->label('Action')
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        str_contains($state, 'created') => 'success',
                        str_contains($state, 'deleted') => 'danger',
                        str_contains($state, 'status') => 'warning',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->wrap()
                    ->searchable(),

                TextColumn::make('subject_type')
                    ->label('Sujet')
                    ->formatStateUsing(fn (?string $state) => $state ? class_basename($state) : '—')
                    ->toggleable(),

                TextColumn::make('causer.name')
                    ->label('Auteur')
                    ->placeholder('Système')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('action')
                    ->label('Type d\'action')
                    ->options([
                        'contact.created' => 'Nouveau contact',
                        'quote.created' => 'Nouveau devis',
                        'quote.status_changed' => 'Statut devis modifié',
                        'appointment.created' => 'Nouveau rendez-vous',
                    ]),

                Filter::make('today')
                    ->label('Aujourd\'hui')
                    ->query(fn (Builder $query) => $query->whereDate('created_at', today())),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentList)
            ->emptyStateHeading('Aucune activité enregistrée')
            ->emptyStateDescription('Les actions importantes apparaîtront ici automatiquement.');
    }
}
