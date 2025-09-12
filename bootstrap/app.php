<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        // Pengecualian untuk Maintenance Mode
        $middleware->preventRequestsDuringMaintenance($except = [
            'admin/*',       // Izinkan akses ke semua URL admin
            'login',         // Izinkan akses ke halaman login
            'logout',        // Izinkan akses untuk logout
            'public/login',  // Izinkan akses jika URL mengandung /public
            'public/logout', // Izinkan akses jika URL mengandung /public
        ]);
        
        // Pengecualian untuk CSRF Token (Webhook Midtrans)
        $middleware->validateCsrfTokens(except: [
            'midtrans/callback',
            'public/midtrans/callback',
        ]);

        // Middleware Grup
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\AffiliateMiddleware::class,
        ]);

        // Middleware Alias
        $middleware->alias([
            'affiliate.active' => \App\Http\Middleware\EnsureUserIsActiveAffiliate::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    })
    ->withProviders([
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
        App\Providers\NotificationServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();