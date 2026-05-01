<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SiteSettingsPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static \UnitEnum|string|null $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Paramètres du site';

    protected static ?int $navigationSort = 99;

    protected string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::getAllCached()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Section::make('Mode maintenance')
                    ->description('Lorsqu\'activé, le site public affiche une page de maintenance. L\'espace admin reste toujours accessible.')
                    ->icon(Heroicon::OutlinedWrenchScrewdriver)
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        Toggle::make('maintenance_mode')
                            ->label('Activer la maintenance')
                            ->helperText('Le site sera inaccessible aux visiteurs.')
                            ->inline(false)
                            ->columnSpanFull(),
                        Textarea::make('maintenance_message')
                            ->label('Message affiché aux visiteurs')
                            ->placeholder('Nous effectuons une mise à jour. Nous revenons très bientôt.')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('maintenance_allowed_ips')
                            ->label('IP autorisées (bypass)')
                            ->prefixIcon(Heroicon::OutlinedShieldCheck)
                            ->placeholder('192.168.1.1, 203.0.113.5')
                            ->helperText('Adresses IP séparées par des virgules qui voient le site normalement.'),
                        TextInput::make('maintenance_bypass_token')
                            ->label('Token de bypass URL')
                            ->prefixIcon(Heroicon::OutlinedKey)
                            ->placeholder('mon-token-secret')
                            ->helperText('Accès via ?bypass=TOKEN dans l\'URL.'),
                    ]),

                Section::make('Identité du cabinet')
                    ->description('Nom, sous-titre et année de fondation affichés sur le site.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        TextInput::make('brand_name')
                            ->label('Nom du cabinet')
                            ->prefixIcon(Heroicon::OutlinedBuildingOffice)
                            ->required(),
                        TextInput::make('brand_tagline')
                            ->label('Sous-titre')
                            ->prefixIcon(Heroicon::OutlinedSparkles)
                            ->placeholder('ex: Conseil & Formation'),
                        TextInput::make('founded_year')
                            ->label('Année de création')
                            ->prefixIcon(Heroicon::OutlinedCalendarDays)
                            ->placeholder('ex: 2010'),
                    ]),

                Section::make('Contact')
                    ->description('Coordonnées affichées dans le footer et sur la page de contact.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        TextInput::make('contact_email')
                            ->label('Email de contact')
                            ->prefixIcon(Heroicon::OutlinedEnvelope)
                            ->email()
                            ->required(),
                        TextInput::make('contact_phone')
                            ->label('Téléphone')
                            ->prefixIcon(Heroicon::OutlinedPhone)
                            ->tel(),
                        TextInput::make('contact_address')
                            ->label('Adresse')
                            ->prefixIcon(Heroicon::OutlinedMapPin)
                            ->columnSpanFull(),
                        TextInput::make('contact_hours')
                            ->label('Horaires d\'ouverture')
                            ->prefixIcon(Heroicon::OutlinedClock)
                            ->placeholder('ex: Lun–Ven : 9h – 18h'),
                        TextInput::make('linkedin_url')
                            ->label('URL LinkedIn')
                            ->prefixIcon(Heroicon::OutlinedLink)
                            ->url(),
                    ]),

                Section::make('Page d\'accueil — Hero')
                    ->description('Contenu de la section hero visible dès l\'arrivée sur le site.')
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        TextInput::make('hero_badge')
                            ->label('Badge (bandeau)')
                            ->placeholder('ex: Cabinet expert en QHSE depuis 2010')
                            ->columnSpanFull(),
                        TextInput::make('hero_title')
                            ->label('Titre principal')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('hero_description')
                            ->label('Description')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Section::make('Chiffres clés')
                    ->description('Statistiques affichées sur la page d\'accueil et à propos.')
                    ->columns(['default' => 1, 'sm' => 2, 'lg' => 4])
                    ->schema([
                        TextInput::make('stat_clients')
                            ->label('Clients')
                            ->prefixIcon(Heroicon::OutlinedUsers),
                        TextInput::make('stat_formations')
                            ->label('Formations')
                            ->prefixIcon(Heroicon::OutlinedAcademicCap),
                        TextInput::make('stat_years')
                            ->label('Années d\'expérience')
                            ->prefixIcon(Heroicon::OutlinedCalendarDays),
                        TextInput::make('stat_satisfaction')
                            ->label('Satisfaction')
                            ->prefixIcon(Heroicon::OutlinedStar),
                    ]),

                Section::make('Page À propos')
                    ->description('Textes narratifs présentant le cabinet et sa philosophie.')
                    ->schema([
                        Textarea::make('about_intro')
                            ->label('Introduction (accroche hero)')
                            ->rows(2),
                        Textarea::make('about_description_1')
                            ->label('Paragraphe 1 — Présentation')
                            ->rows(3),
                        Textarea::make('about_description_2')
                            ->label('Paragraphe 2 — Approche')
                            ->rows(3),
                        Textarea::make('about_description_3')
                            ->label('Paragraphe 3 — Vision')
                            ->rows(3),
                    ]),

                Section::make('Footer')
                    ->description('Texte court affiché dans le bas de page du site.')
                    ->schema([
                        Textarea::make('footer_description')
                            ->label('Description courte (footer)')
                            ->rows(2),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();
        SiteSetting::setMany($data);

        Notification::make()
            ->title('Paramètres sauvegardés')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Sauvegarder les paramètres')
                ->submit('save'),
        ];
    }
}
