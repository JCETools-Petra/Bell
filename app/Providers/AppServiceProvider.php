<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HomepageSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Channels\WhatsAppChannel;
use App\Models\ContactSetting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Biarkan kosong
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Ambil pengaturan homepage
            $homepageSettings = Cache::remember('homepage_settings', now()->addMinutes(60), function () {
                try {
                    return HomepageSetting::pluck('value', 'key')->all();
                } catch (\Exception $e) {
                    return [];
                }
            });

            // Ambil pengaturan kontak
            $contactSettings = Cache::remember('contact_settings', now()->addMinutes(60), function () {
                try {
                    return ContactSetting::pluck('value', 'key')->all();
                } catch (\Exception $e) {
                    return [];
                }
            });

            // Gabungkan kedua pengaturan menjadi satu array '$settings'
            $settings = array_merge($homepageSettings, $contactSettings);

            // Kirim array yang sudah digabung ke semua view
            $view->with('settings', $settings);
        });

        // 2. Mendaftarkan channel notifikasi WhatsApp kustom
        //    Ini memberitahu Laravel cara mengirim notifikasi via WhatsApp.
        Notification::extend('whatsapp', function ($app) {
            return new \App\Notifications\Channels\WhatsAppChannel();
        });
    }
}