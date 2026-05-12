<?php

namespace App\Filament\Pages;

use App\Models\MaintenanceLog;
use App\Models\SiteSetting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

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

                Section::make('Devis & Documents PDF')
                    ->description('Informations légales et visuels utilisés sur les PDF de devis et factures.')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->columns(['default' => 1, 'sm' => 2])
                    ->schema([
                        FileUpload::make('quote_logo')
                            ->label('Logo (PDF)')
                            ->image()
                            ->disk('public')
                            ->directory('documents')
                            ->hint('Format recommandé : PNG transparent, 400 × 120 px')
                            ->columnSpanFull(),

                        FileUpload::make('quote_signature')
                            ->label('Signature du cabinet')
                            ->image()
                            ->disk('public')
                            ->directory('documents')
                            ->hint('Image de votre signature manuscrite (PNG fond transparent)')
                            ->columnSpanFull(),

                        TextInput::make('quote_legal_name')
                            ->label('Raison sociale')
                            ->prefixIcon(Heroicon::OutlinedBuildingOffice2)
                            ->placeholder('OBSAQUIM SAS'),

                        TextInput::make('quote_siret')
                            ->label('N° SIRET')
                            ->prefixIcon(Heroicon::OutlinedIdentification)
                            ->placeholder('123 456 789 00012'),

                        TextInput::make('quote_vat')
                            ->label('N° TVA intracommunautaire')
                            ->prefixIcon(Heroicon::OutlinedReceiptPercent)
                            ->placeholder('FR 12 345678900'),

                        TextInput::make('quote_ape')
                            ->label('Code APE / NAF')
                            ->prefixIcon(Heroicon::OutlinedTag)
                            ->placeholder('7490B'),

                        TextInput::make('quote_capital')
                            ->label('Capital social')
                            ->prefixIcon(Heroicon::OutlinedBanknotes)
                            ->placeholder('10 000 €'),

                        TextInput::make('quote_iban')
                            ->label('IBAN')
                            ->prefixIcon(Heroicon::OutlinedCreditCard)
                            ->placeholder('FR76 3000 4000 0100 0000 0000 000')
                            ->columnSpanFull(),

                        TextInput::make('quote_bank_name')
                            ->label('Banque')
                            ->prefixIcon(Heroicon::OutlinedBuildingLibrary)
                            ->placeholder('BNP Paribas'),

                        TextInput::make('quote_currency')
                            ->label('Devise (symbole)')
                            ->prefixIcon(Heroicon::OutlinedCurrencyDollar)
                            ->placeholder('XOF')
                            ->hint('Symbole affiché sur les devis et factures PDF.')
                            ->default('XOF'),

                        TextInput::make('quote_validity_days')
                            ->label('Validité du devis (jours)')
                            ->numeric()
                            ->default(30)
                            ->prefixIcon(Heroicon::OutlinedCalendarDays),

                        Section::make('Numérotation des références')
                            ->description('Définit le format de génération automatique des numéros de devis. Aperçu : PREFIX-AAAA-MM-0001')
                            ->compact()
                            ->columnSpanFull()
                            ->schema([
                                TextInput::make('quote_ref_prefix')
                                    ->label('Préfixe')
                                    ->placeholder('DEV')
                                    ->default('DEV')
                                    ->maxLength(10)
                                    ->prefixIcon(Heroicon::OutlinedTag),

                                TextInput::make('quote_ref_padding')
                                    ->label('Nombre de chiffres (padding)')
                                    ->numeric()
                                    ->default(4)
                                    ->minValue(1)
                                    ->maxValue(8)
                                    ->prefixIcon(Heroicon::OutlinedHashtag)
                                    ->helperText('Ex: 4 → 0001, 5 → 00001'),

                                Toggle::make('quote_ref_include_year')
                                    ->label('Inclure l\'année')
                                    ->default(true)
                                    ->inline(false),

                                Toggle::make('quote_ref_include_month')
                                    ->label('Inclure le mois')
                                    ->default(false)
                                    ->inline(false),
                            ])->columns(['default' => 1, 'sm' => 2]),

                        Textarea::make('quote_terms')
                            ->label('Conditions générales de vente')
                            ->rows(8)
                            ->placeholder("Article 1 — Objet\nLes présentes conditions générales de vente s'appliquent à toutes les prestations de services conclues par le cabinet...\n\nArticle 2 — Prix\nLes prix sont indiqués en euros hors taxes...")
                            ->hint('Ces conditions apparaîtront en bas du PDF de devis.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $wasActive = (bool) SiteSetting::get('maintenance_mode', false);
        $isActive = (bool) ($data['maintenance_mode'] ?? false);

        SiteSetting::setMany($data);

        if (! $wasActive && $isActive) {
            MaintenanceLog::create([
                'started_at' => now(),
                'started_by' => auth()->id(),
                'message' => $data['maintenance_message'] ?? null,
            ]);
        } elseif ($wasActive && ! $isActive) {
            MaintenanceLog::closeCurrent(auth()->id());
        }

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
