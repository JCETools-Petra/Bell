<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hero_title', 'value' => 'BELL HOTEL Merauke'],
            ['key' => 'hero_subtitle', 'value' => 'Bell Hotel Merauke, hotel modern yang terletak strategis...'],
            ['key' => 'about_title', 'value' => 'PROMO DISCOUNT 20%'],
            ['key' => 'about_content', 'value' => 'silahkan hubungi admin kami untuk discount yang sedang berlaku'],
            ['key' => 'hero_text_align', 'value' => 'text-center'],
            ['key' => 'hero_bg_image', 'value' => 'homepage/7P6miyMJ7Ygbnt8tO1vsUtcCqYnUrtCEO1rxfEVc.jpg'],
            ['key' => 'website_title', 'value' => 'Bell Hotel Merauke'],
            ['key' => 'featured_display_option', 'value' => 'rooms,mice,restaurants'],
            ['key' => 'logo_path', 'value' => 'settings/qVa09dyFoKY7r7goKXdknbUIY7QEEo02KA7eKIid.png'],
            ['key' => 'favicon_path', 'value' => 'settings/23bkqNC2NPBHMAkbhoOljkCLrquQTAKjf8JmyT15.png'],
            ['key' => 'logo_height', 'value' => '50'],
            ['key' => 'show_logo_text', 'value' => '0'],
            ['key' => 'contact_address', 'value' => 'Jl. Prajurit, Mandala, Kec. Merauke, Kabupaten Merauke, Papua 99614'],
            ['key' => 'contact_phone', 'value' => '08114821323'],
            ['key' => 'contact_email', 'value' => 'frontoffice@bellhotelmerauke.com'],
            ['key' => 'contact_instagram', 'value' => 'https://www.instagram.com/ghmhotel.merauke/'],
            ['key' => 'contact_facebook', 'value' => 'https://www.facebook.com/ghmhotel.merauke'],
            ['key' => 'contact_linkedin', 'value' => 'https://www.linkedin.com/company/ghmmerauke'],
            ['key' => 'contact_youtube', 'value' => 'https://www.youtube.com/@ghmhotel.merauke'],
            ['key' => 'contact_tiktok', 'value' => 'https://www.tiktok.com/@ghmhotel.merauke'],
            ['key' => 'terms_and_conditions', 'value' => '<h1>Terms and Conditions</h1><p>Please update this content from the admin panel.</p>'],
            ['key' => 'contact_maps_embed', 'value' => null],
        ];

        DB::table('settings')->truncate(); // Hapus data lama dulu
        DB::table('settings')->insert($settings);
    }
}