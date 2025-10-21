<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Commissions;
// use App\Filament\Pages\Dashboard;
use App\Models\Commission;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
// use Filament\Pages\Dashboard as PagesDashboard;
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

class AdminPanelProvider extends PanelProvider
{
    // public function __construct()
    // {
    // }
    public function panel(Panel $panel): Panel
    {
        // dd(Filament::getCurrentPanel(), $this, Commissions::getUrl(panel:'admin'));
       

        // dd(Filament::getCurrentPanel(), 
        // route(Commissions::getRouteName(), [], false)
        // );

        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->profile()
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                \Filament\Pages\Dashboard::class,
                // Dashboard::class,
                // Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
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
            ])
            ->authGuard('admin')
            ->navigationItems([
                NavigationItem::make('Commission')
                    ->label('Commission Setting')
                    ->url(fn() => Commissions::getUrl(['activeTab' => Commissions::REFERRALS_TAB]))
                    // ['activeTab' => Commissions::REFERRALS_TAB]
                    // ->icon('heroicon-o-presentation-chart-line')
                    ->group('Deposit')
                    ->sort(3)
                    ->isActiveWhen(function () {
                        $commissionPage = Commissions::getUrl(['activeTab' => Commissions::REFERRALS_TAB]);
                        return $commissionPage == request()->getUri();
                    }),
            ])
    
            ->navigationGroups([
                NavigationGroup::make()
                     ->label('Deposit')
                     ->icon('heroicon-o-queue-list'),
                NavigationGroup::make()
                     ->label('Investment')
                     ->icon('heroicon-o-globe-alt'),
                NavigationGroup::make()
                     ->label('Staking Investment')
                     ->icon('heroicon-o-calendar-days'),
                NavigationGroup::make()
                     ->label('Withdrawals')
                     ->icon('heroicon-o-rectangle-stack'),

                NavigationGroup::make()
                    ->label('Matrix Scheme')
                    ->icon('heroicon-o-chart-bar'),
                NavigationGroup::make()
                    ->label('Trade')
                    ->icon('heroicon-o-presentation-chart-line'),
                NavigationGroup::make()
                    ->label('Settings')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed(),
                // NavigationGroup::make()
                //     ->label('Staking Investment')
                //     ->icon('heroicon-o-shopping-cart'),
            ])
            ->darkMode(true, true)
            ->databaseNotifications()
            ->viteTheme('resources/css/filament/admin/theme.css');
    }
}
