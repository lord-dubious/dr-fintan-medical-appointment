<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        // Share authentication state with all views
        View::composer('*', function ($view) {
            $view->with('currentUser', Auth::user());
            $view->with('isAuthenticated', Auth::check());
        });
    }
}
