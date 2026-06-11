<?php

namespace App\Filament\Resources\DiagnosticRequests\Tables;

use App\Models\DiagnosticRequest;
use App\Models\Quote;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DiagnosticRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reference')
                    ->label('Référence')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('client_name')
                    ->label('Contact')
                    ->searchable()
                    ->description(fn ($record) => $record->client_company),

                TextColumn::make('client_email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sector')
                    ->label('Secteur')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'requested' => 'Demandé',
                        'scheduled' => 'Planifié',
                        'in_progress' => 'En cours',
                        'completed' => 'Terminé',
                        'cancelled' => 'Annulé',
                        'converted' => 'Converti',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'requested' => 'warning',
                        'scheduled' => 'info',
                        'in_progress' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'gray',
                        'converted' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('scheduled_date')
                    ->label('Planifié le')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('consultant.name')
                    ->label('Consultant')
                    ->placeholder('-'),

                IconColumn::make('is_converted')
                    ->label('Converti')
                    ->boolean()
                    ->getStateUsing(fn (DiagnosticRequest $record) => $record->isConverted()),

                TextColumn::make('created_at')
                    ->label('Demandé le')
                    ->date('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->native(false)
                    ->options([
                        'requested' => 'Demandé',
                        'scheduled' => 'Planifié',
                        'in_progress' => 'En cours',
                        'completed' => 'Terminé',
                        'cancelled' => 'Annulé',
                        'converted' => 'Converti',
                    ]),
                SelectFilter::make('company_size')
                    ->label('Taille')
                    ->native(false)
                    ->options([
                        'micro' => 'Micro',
                        'small' => 'Petite',
                        'medium' => 'Moyenne',
                        'large' => 'Grande',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedClipboardDocumentCheck)
            ->emptyStateHeading('Aucun diagnostic')
            ->emptyStateDescription('Les demandes de diagnostic gratuit apparaîtront ici.')
            ->recordActions([
                Action::make('schedule')
                    ->label('Planifier')
                    ->icon(Heroicon::OutlinedCalendarDays)
                    ->color('info')
                    ->visible(fn (DiagnosticRequest $record) => $record->status === 'requested')
                    ->form([
                        DatePicker::make('scheduled_date')
                            ->label('Date planifiée')
                            ->required(),
                        Select::make('assigned_to')
                            ->label('Consultant')
                            ->options(fn () => User::pluck('name', 'id'))
                            ->searchable()
                            ->native(false)
                            ->required(),
                    ])
                    ->action(function (DiagnosticRequest $record, array $data): void {
                        $record->update([
                            'status' => 'scheduled',
                            'scheduled_date' => $data['scheduled_date'],
                            'assigned_to' => $data['assigned_to'],
                        ]);

                        Notification::make()
                            ->title('Diagnostic planifié')
                            ->body("Le diagnostic {$record->reference} est maintenant planifié.")
                            ->success()
                            ->send();
                    }),

                Action::make('mark_completed')
                    ->label('Marquer terminé')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (DiagnosticRequest $record) => in_array($record->status, ['scheduled', 'in_progress']))
                    ->requiresConfirmation()
                    ->action(function (DiagnosticRequest $record): void {
                        $record->update(['status' => 'completed', 'completed_date' => now()]);

                        Notification::make()
                            ->title('Diagnostic terminé')
                            ->body("Le diagnostic {$record->reference} est marqué comme terminé.")
                            ->success()
                            ->send();
                    }),

                Action::make('convert_to_quote')
                    ->label('Convertir en devis')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->color('primary')
                    ->visible(fn (DiagnosticRequest $record) => $record->canBeConverted())
                    ->requiresConfirmation()
                    ->modalHeading('Convertir en devis')
                    ->modalDescription('Un devis sera créé avec les informations de ce diagnostic.')
                    ->action(function (DiagnosticRequest $record): void {
                        $quote = Quote::create([
                            'reference' => 'DEV-'.now()->format('Y').'-'.str_pad((Quote::max('id') ?? 0) + 1, 4, '0', STR_PAD_LEFT),
                            'client_name' => $record->client_name,
                            'client_email' => $record->client_email,
                            'client_phone' => $record->client_phone,
                            'client_company' => $record->client_company,
                            'client_address' => $record->client_address,
                            'service_type' => 'strategic',
                            'status' => 'draft',
                            'notes' => "Converti depuis le diagnostic {$record->reference}.\n\nÉcarts identifiés :\n{$record->gaps_identified}\n\nRecommandations :\n{$record->recommendations}",
                        ]);

                        $record->update([
                            'status' => 'converted',
                            'converted_to_quote_id' => $quote->id,
                            'converted_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Devis créé')
                            ->body("Le devis {$quote->reference} a été créé avec succès.")
                            ->success()
                            ->send();
                    }),

                Action::make('view_quote')
                    ->label('Voir le devis')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->visible(fn (DiagnosticRequest $record) => $record->isConverted())
                    ->url(fn (DiagnosticRequest $record) => route('filament.admin.resources.quotes.edit', $record->converted_to_quote_id))
                    ->openUrlInNewTab(),

                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
