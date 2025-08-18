<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HomepageSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Channels\WhatsAppChannel;

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
        // Kode View Composer Anda sudah benar, tidak perlu diubah.
        View::composer(['layouts.app', 'layouts.frontend'], function ($view) {
            $settings = Cache::remember('homepage_settings', now()->addMinutes(60), function () {
                try {
                    return HomepageSetting::pluck('value', 'key')->all();
                } catch (\Exception $e) {
                    return [];
                }
            });

            $view->with('settings', $settings);
        });

        // Daftarkan channel notifikasi WhatsApp kustom
        Notification::extend('whatsapp', function ($app) {
            return new WhatsAppChannel();
        });
    }
}