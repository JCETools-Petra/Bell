<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\HomepageSetting;
use Illuminate\Support\Facades\Cache;

class ViewServiceProvider extends ServiceProvider
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
        // Menggunakan composer untuk layout backend dan frontend
        View::composer(['layouts.app', 'layouts.frontend'], function ($view) {
            // Mengambil settings dari cache untuk efisiensi, atau dari DB jika tidak ada
            $settings = Cache::remember('homepage_settings', 60, function () {
                return HomepageSetting::pluck('value', 'key')->all();
            });
            
            $view->with('settings', $settings);
        });
    }
}