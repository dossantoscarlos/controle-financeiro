<?php

namespace App\Providers;

use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('jquery.min', __DIR__ . '/../../resources/js/jquery.min.js'),
            Js::make('jquery.mask.min', __DIR__ . '/../../resources/js/jquery.mask.min.js'),
            Js::make('priceMask', __DIR__ . '/../../resources/js/priceMask.js'),
        ]);
    }
}
