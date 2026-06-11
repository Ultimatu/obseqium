<?php

namespace App\Filament\Resources\Contacts\Tables;

use App\Filament\Exports\ContactExporter;
use App\Models\Contact;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nom')->searchable()->description(fn ($record) => $record->company),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('subject')->label('Objet')->searchable()->limit(50),
                TextColumn::make('meeting_format')
                    ->label('Format')
                    ->badge()
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'presentiel' => 'Présentiel',
                        'visio' => 'Visio',
                        'client' => 'Chez le client',
                        default => '-',
                    })
                    ->color(fn (?string $state) => match ($state) {
                        'presentiel' => 'success',
                        'visio' => 'info',
                        'client' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('message')->label('Message')->limit(60)->wrap()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_read')->label('Lu')->boolean(),
                TextColumn::make('assignee.name')->label('Assigné à')->placeholder('Non assigné'),
                TextColumn::make('created_at')->label('Reçu le')->date('d/m/Y')->sortable(),
            ])
            ->filters([TernaryFilter::make('is_read')->label('Lu')])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedEnvelope)
            ->emptyStateHeading('Aucune demande de contact')
            ->emptyStateDescription('Les nouvelles demandes apparaîtront ici.')
            ->recordActions([
                Action::make('toggleRead')
                    ->label(fn (Contact $record) => $record->is_read ? 'Marquer non lu' : 'Marquer lu')
                    ->icon(fn (Contact $record) => $record->is_read ? Heroicon::OutlinedEnvelopeOpen : Heroicon::OutlinedEnvelope)
                    ->color(fn (Contact $record) => $record->is_read ? 'gray' : 'success')
                    ->action(fn (Contact $record) => $record->update([
                        'is_read' => ! $record->is_read,
                        'read_at' => ! $record->is_read ? now() : null,
                    ])),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()->exporter(ContactExporter::class)->label('Exporter'),
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
