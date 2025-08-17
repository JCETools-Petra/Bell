<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HomepageSetting;

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
        // Bagikan data 'settings' ke semua view di dalam folder 'frontend'
        View::composer('frontend.*', function ($view) {
            $settings = HomepageSetting::all()->pluck('value', 'key');
            $view->with('settings', $settings);
        });
    }
}