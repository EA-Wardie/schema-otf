<?php

namespace App\Providers\Filament;

use App\Filament\Main\Resources\Collections\Pages\ViewCollection;
use App\Models\Collection;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use function Filament\Support\original_request;

class MainPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $collectionNavigationItems = Collection::orderBy('name')
            ->get()
            ->map(fn(Collection $collection, $index) => NavigationItem::make($collection->name)
                ->isActiveWhen(fn() => original_request()->fullUrl() === ViewCollection::getUrl(parameters: ['record' => $collection], panel: 'main'))
                ->url(fn() => ViewCollection::getUrl(parameters: ['record' => $collection], panel: 'main'))
                ->group('Collections')
                ->sort($index))
            ->toArray();

        return $panel
            ->default()
            ->id('main')
            ->path('')
            ->colors(['primary' => Color::Teal])
            ->login()
            ->registration()
            ->profile()
            ->discoverResources(in: app_path('Filament/Main/Resources'), for: 'App\Filament\Main\Resources')
            ->discoverPages(in: app_path('Filament/Main/Pages'), for: 'App\Filament\Main\Pages')
            ->discoverWidgets(in: app_path('Filament/Main/Widgets'), for: 'App\Filament\Main\Widgets')
            ->collapsibleNavigationGroups(false)
            ->navigationItems($collectionNavigationItems)
            ->pages([
                Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
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
