<?php

namespace App\Providers;

use App\Models\SalonSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Partage les paramètres du salon avec TOUTES les vues Blade.
        // Utilisation : $salonSettings->salon_name, $salonSettings->facebook, etc.
        View::composer('*', function ($view) {
            try {
                $view->with('salonSettings', SalonSetting::current());
            } catch (\Throwable $e) {
                // Si la base ou la table n'est pas encore prête
                $view->with('salonSettings', new SalonSetting());
            }
        });
    }
}
