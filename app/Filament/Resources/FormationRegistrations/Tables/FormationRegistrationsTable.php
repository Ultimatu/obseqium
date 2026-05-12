<?php

namespace App\Filament\Resources\FormationRegistrations\Tables;

use App\Filament\Exports\FormationRegistrationExporter;
use App\Mail\AttestationMail;
use App\Models\FormationRegistration;
use App\Models\SiteSetting;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class FormationRegistrationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('session.formation.title')->label('Formation')->searchable()->wrap(),
                TextColumn::make('session.start_date')->label('Date session')->date('d/m/Y'),
                TextColumn::make('user.name')->label('Client')->searchable()->placeholder(fn ($record) => $record->guest_name),
                TextColumn::make('guest_email')->label('Email')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('guest_company')->label('Société')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                        'completed' => 'Terminée',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')->label('Inscrit le')->date('d/m/Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'pending' => 'En attente',
                        'confirmed' => 'Confirmée',
                        'cancelled' => 'Annulée',
                        'completed' => 'Terminée',
                    ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->emptyStateIcon(Heroicon::OutlinedAcademicCap)
            ->emptyStateHeading('Aucune inscription')
            ->emptyStateDescription('Les inscriptions aux formations apparaîtront ici.')
            ->recordActions([
                Action::make('confirm')
                    ->label('Confirmer')
                    ->icon(Heroicon::OutlinedCheckCircle)
                    ->color('success')
                    ->visible(fn (FormationRegistration $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Confirmer l\'inscription')
                    ->action(fn (FormationRegistration $record) => $record->update([
                        'status' => 'confirmed',
                        'confirmed_at' => now(),
                    ])),
                Action::make('cancel')
                    ->label('Annuler')
                    ->icon(Heroicon::OutlinedXCircle)
                    ->color('danger')
                    ->visible(fn (FormationRegistration $record) => in_array($record->status, ['pending', 'confirmed']))
                    ->requiresConfirmation()
                    ->modalHeading('Annuler l\'inscription')
                    ->action(fn (FormationRegistration $record) => $record->update([
                        'status' => 'cancelled',
                        'cancelled_at' => now(),
                    ])),
                Action::make('send_attestation')
                    ->label('Envoyer attestation')
                    ->icon(Heroicon::OutlinedAcademicCap)
                    ->color('info')
                    ->visible(fn (FormationRegistration $record) => in_array($record->status, ['confirmed', 'completed']))
                    ->requiresConfirmation()
                    ->modalHeading('Générer et envoyer l\'attestation')
                    ->modalDescription(fn (FormationRegistration $record) => 'Envoyer l\'attestation PDF à '.($record->user?->email ?? $record->guest_email).' ?')
                    ->action(function (FormationRegistration $record): void {
                        $registration = $record->load(['session.formation', 'user']);
                        $settings = SiteSetting::getAllCached();

                        $pdf = Pdf::loadView('pdfs.attestation', [
                            'registration' => $registration,
                            'session' => $registration->session,
                            'formation' => $registration->session->formation,
                            'settings' => $settings,
                        ])->setPaper('a4');

                        $path = 'attestations/'.$registration->id.'-'.now()->format('YmdHis').'.pdf';
                        $fullPath = 'public/'.$path;
                        Storage::put($fullPath, $pdf->output());
                        $registration->update(['attestation_path' => $path]);

                        $recipient = $registration->user?->email ?? $registration->guest_email;
                        $name = $registration->user?->name ?? $registration->guest_name;
                        Mail::to($recipient, $name)->send(new AttestationMail($registration));

                        Notification::make()
                            ->title('Attestation envoyée')
                            ->body('PDF généré et email envoyé à '.$recipient.'.')
                            ->success()
                            ->send();
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportAction::make()->exporter(FormationRegistrationExporter::class)->label('Exporter'),
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}
