<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification; // <-- Ini dipertahankan
// Hapus semua 'use' statement yang tidak perlu seperti View, Cache, HomepageSetting, dll.

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
        // HAPUS SEMUA KODE View::composer DARI SINI.
        // Logika tersebut sudah ditangani oleh ViewServiceProvider.

        // PERTAHANKAN kode ini karena ini penting untuk notifikasi WhatsApp Anda.
        Notification::extend('whatsapp', function ($app) {
            return new \App\Notifications\Channels\WhatsAppChannel();
        });
    }
}