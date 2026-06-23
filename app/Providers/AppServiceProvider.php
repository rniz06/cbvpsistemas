<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
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
        // Define al rol SuporAdmin como el rol que tiene acceso a todas las acciones
        // de la aplicación, sin importar el modelo o la acción.
        Gate::before(function ($user, $ability) {
            return $user->hasRole('SuperAdmin') ? true : null;
        });
        if (request()->header('x-forwarded-proto') == 'https') {
            URL::forceScheme('https');
        }
    }
}
