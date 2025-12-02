<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\RecreationArea::class => \App\Policies\RecreationAreaPolicy::class,
        \App\Models\Room::class => \App\Policies\RoomPolicy::class,
        \App\Models\MiceRoom::class => \App\Policies\MiceRoomPolicy::class,
        \App\Models\Restaurant::class => \App\Policies\RestaurantPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /**
         * Mendefinisikan Gate untuk manajemen komisi.
         * Mengembalikan true jika peran pengguna adalah 'admin' atau 'accounting'.
         */
        Gate::define('manage-commissions', function ($user) {
            // Tambahkan 'frontoffice' ke dalam array
            return in_array($user->role, ['admin', 'accounting', 'frontoffice']);
        });

        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });
    }
}