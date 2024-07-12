<?php

namespace App\Providers\Filament;

use App\Filament\Pages\CustomerLogin;
use App\Filament\Pages\CustomerRegister;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class CustomerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('customer')
            ->path('/')
            ->default()
            ->login(CustomerLogin::class)
            // ->login()

            ->registration(CustomerRegister::class)
            ->passwordReset() 
            ->brandLogo(asset('images/logo-transparent.png'))
            ->favicon(asset('images/logo-transparent.png'))
            // ->brandLogoHeight('2rem')
            ->authGuard('customers')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->databaseNotifications()
            ->topNavigation()
            ->discoverResources(in: app_path('Filament/CustomerResources'), for: 'App\\Filament\\CustomerResources')
            ->discoverPages(in: app_path('Filament/Customer/Pages'), for: 'App\\Filament\\Customer\\Pages')
            ->discoverClusters(in: app_path('Filament/Customer/discoverClusters'), for: 'App\\Filament\\Customer\\discoverClusters')
            ->pages([
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Customer/Widgets'), for: 'App\\Filament\\Customer\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
