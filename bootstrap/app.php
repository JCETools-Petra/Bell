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
    
    $middleware->appendToGroup('web', [
            \App\Http\Middleware\AffiliateMiddleware::class,
        ]);

        $middleware->alias([
            'affiliate.active' => \App\Http\Middleware\EnsureUserIsActiveAffiliate::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

    })
    ->withProviders([ // <-- Tambahkan bagian withProviders
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
        App\Providers\NotificationServiceProvider::class,
    ])
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();