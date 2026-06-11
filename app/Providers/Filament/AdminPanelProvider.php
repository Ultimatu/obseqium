<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\StatsOverviewWidget;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Cabinet QHSE')
            ->colors([
                'primary' => Color::hex('#1a7a4a'),
                'gray' => Color::Slate,
            ])
            ->databaseNotifications()
            ->navigationGroups([
                NavigationGroup::make('Commercial')->icon(Heroicon::OutlinedBriefcase)->collapsible(false),
                NavigationGroup::make('Clients')->icon(Heroicon::OutlinedUsers)->collapsible(false),
                NavigationGroup::make('Catalogue')->icon(Heroicon::OutlinedAcademicCap)->collapsible(false),
                NavigationGroup::make('Contenu')->icon(Heroicon::OutlinedSquares2x2)->collapsible(false),
                // Projets et tâches sont regroupés dans une même section pour simplifier la navigation
                NavigationGroup::make('Projets')->icon(Heroicon::OutlinedFolderOpen)->collapsible(false),
                NavigationGroup::make('Blog')->icon(Heroicon::OutlinedNewspaper)->collapsible(false),
                NavigationGroup::make('Site Web')->icon(Heroicon::OutlinedGlobeAlt)->collapsible(false),
                NavigationGroup::make('Administration')->icon(Heroicon::OutlinedCog6Tooth)->collapsible(false),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                StatsOverviewWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
