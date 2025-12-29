<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
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
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
        //
        // parent::boot();

        Route::middleware('web')
            ->group(base_path('routes/e-commerce.php'));

        Route::middleware('web')
            ->group(base_path('routes/warehouse.php'));

        Route::middleware('web')
            ->group(base_path('routes/frontend.php'));
    }
}
