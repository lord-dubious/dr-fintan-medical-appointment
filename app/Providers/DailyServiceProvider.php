<?php

namespace App\Providers;

use App\Services\Daily\Daily;
use Illuminate\Support\ServiceProvider;

class DailyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('daily', function () {
            return new Daily;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
