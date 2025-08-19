<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingsTableSeeder::class,
            UsersTableSeeder::class,
            RoomsAndImagesSeeder::class,
            MiceRoomsAndImagesSeeder::class,
            RestaurantsAndImagesSeeder::class,
            AffiliatesAndCommissionsSeeder::class,
            BookingsTableSeeder::class, // Booking bergantung pada rooms dan affiliates
        ]);
    }
}