<?php

namespace App\Providers;

use App\Models\CouponUsage;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestProduct;
use App\Models\ServiceRequestProductRequestPart;
use App\Observers\CouponUsageObserver;
use App\Observers\ServiceRequestObserver;
use App\Observers\ServiceRequestProductObserver;
use App\Observers\ServiceRequestProductRequestPartObserver;
use App\Services\FirebaseStorageService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FirebaseStorageService::class, function () {
            return new FirebaseStorageService;
        });

        $this->app->singleton('firebase.storage', function ($app) {
            return $app->make(FirebaseStorageService::class);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register observers
        ServiceRequest::observe(ServiceRequestObserver::class);
        ServiceRequestProduct::observe(ServiceRequestProductObserver::class);
        ServiceRequestProductRequestPart::observe(ServiceRequestProductRequestPartObserver::class);
        CouponUsage::observe(CouponUsageObserver::class);

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Route::middleware('web')
            ->group(base_path('routes/e-commerce.php'));

        Route::middleware('web')
            ->group(base_path('routes/warehouse.php'));

        Route::middleware('web')
            ->group(base_path('routes/frontend.php'));

        Route::middleware('web')
            ->group(base_path('routes/offline.php'));

        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
