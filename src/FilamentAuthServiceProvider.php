<?php

namespace Statview\FilamentAuth;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Http\Middleware\CheckForAnyScope;
use Laravel\Passport\Http\Middleware\CheckScopes;
use Laravel\Passport\Passport;
use Livewire\Livewire;
use Statview\FilamentAuth\Console\InstallAuthorizeView;
use Statview\FilamentAuth\Filament\Pages\Login;
use Statview\FilamentAuth\Models\Client;

class FilamentAuthServiceProvider extends ServiceProvider
{
    public function register()
    {
        Passport::ignoreRoutes();
        Passport::ignoreMigrations();
        Passport::useClientModel(Client::class);

        $this->loadRoutesFrom(__DIR__.'/../routes/filament-auth.php');

        $this->commands([
            InstallAuthorizeView::class,
        ]);

        app('router')->aliasMiddleware('scopes', CheckScopes::class);
        app('router')->aliasMiddleware('scope', CheckForAnyScope::class);
    }

    public function boot()
    {
        Passport::tokensCan([
            'email' => 'Read emailaddress',
        ]);

        Livewire::component('statview.filament-auth.filament.pages.login', Login::class);

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filament-auth');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}