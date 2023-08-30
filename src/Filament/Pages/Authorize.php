<?php

namespace Statview\FilamentAuth\Filament\Pages;

use Filament\Pages\SimplePage;

class Authorize extends SimplePage
{
    public function render(): \Illuminate\Contracts\View\View
    {
        return view('filament-auth::filament.pages.authorize')
            ->layout('filament-panels::components.layout.simple');
    }
}