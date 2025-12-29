<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Activitylog\Models\Activity;

class ActivityLogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Automatically add IP address to all activity logs
        Activity::saving(function (Activity $activity) {
            $properties = $activity->properties ?? collect();

            if (! $properties->has('ip')) {
                $activity->properties = $properties->put('ip', request()->ip());
            }

            if (! $properties->has('user_agent')) {
                $activity->properties = $properties->put('user_agent', request()->userAgent());
            }
        });
    }
}
