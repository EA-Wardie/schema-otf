<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Login;
use App\Filament\Pages\Register;
use App\Filament\Resources\Collections\Pages\ViewCollection;
use App\Models\Collection;
use Filament\Actions\Action;
use Filament\Enums\ThemeMode;
use Filament\Enums\UserMenuPosition;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use function Filament\Support\original_request;

class AppPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $collectionNavigationItems = Collection::orderBy('name')
            ->get()
            ->map(fn(Collection $collection, $index) => NavigationItem::make($collection->name)
                ->isActiveWhen(fn() => original_request()->fullUrl() === ViewCollection::getUrl(parameters: ['record' => $collection], panel: 'main'))
                ->url(fn() => ViewCollection::getUrl(parameters: ['record' => $collection], panel: 'main'))
                ->sort($index))
            ->toArray();

        return $panel
            ->id('main')
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->viteTheme('resources/css/filament/theme.css')
            ->userMenu(position: UserMenuPosition::Sidebar)
            ->collapsibleNavigationGroups(false)
            ->navigationItems($collectionNavigationItems)
            ->defaultThemeMode(ThemeMode::Dark)
            ->darkMode(true, true)
            ->registration(action: Register::class)
            ->brandLogo(asset('/images/logo.svg'))
            ->brandLogoHeight('2rem')
            ->brandName(config('app.name'))
            ->topbar(false)
            ->favicon(asset('/favicon.svg'))
            ->colors(['primary' => Color::Teal])
            ->login(action: Login::class)
            ->databaseTransactions()
            ->unsavedChangesAlerts()
            ->path('')
            ->profile()
            ->default()
            ->userMenuItems([
                'profile' => fn(Action $action) => $action->label(auth()->user()->name),
                'logout' => fn(Action $action) => $action->requiresConfirmation(),
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
