<?php

use Illuminate\Support\Facades\Route;
use Statview\FilamentAuth\Filament\Pages\Login;
use Statview\FilamentAuth\Http\Controllers\RevokeOAuthController;
use Statview\FilamentAuth\Http\Controllers\UserOAuthController;

Route::get('filament-auth/login', Login::class)->name('login')->middleware(['web']);

ray(config('auth'));

Route::group([
    'as' => 'filament-auth.sso.',
    'prefix' => 'filament-auth/sso',
    'namespace' => '\Laravel\Passport\Http\Controllers',
], function () {
    Route::get('/authorize', [
        'uses' => 'AuthorizationController@authorize',
        'as' => 'authorizations.authorize',
        'middleware' => ['web', 'panel:app'],
    ]);

    Route::post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'as' => 'token',
        'middleware' => 'throttle',
    ]);

    $guard = config('passport.guard');

    Route::middleware(['web', $guard ? 'auth:' . $guard : 'auth'])
        ->group(function () {
            Route::post('/authorize', [
                'uses' => 'ApproveAuthorizationController@approve',
                'as' => 'authorizations.approve',
            ]);

            Route::delete('/authorize', [
                'uses' => 'DenyAuthorizationController@deny',
                'as' => 'authorizations.deny',
            ]);
        });
});

Route::middleware(['api', 'auth:filament'])->group(function () {
    Route::get('filament-auth/sso/user', UserOAuthController::class)->middleware('scopes:email');

    Route::delete('filament-auth/sso/revoke', RevokeOAuthController::class);
});
