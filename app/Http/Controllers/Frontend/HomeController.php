<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Room;
use App\Models\MiceRoom;
use App\Models\Restaurant;
use App\Models\Banner;
use App\Models\RestaurantImage; // Pastikan ini di-import
use Illuminate\Support\Facades\Auth;
use App\Models\HeroSlider;
use App\Services\PricingService;

class HomeController extends Controller
{
    public function index(PricingService $pricingService)
    {
        $settings = Setting::pluck('value', 'key')->all();
        $featuredOptions = explode(',', $settings['featured_display_option'] ?? 'rooms');

        $featuredRooms = collect();
        $featuredMice = collect();
        $featuredRestaurantImages = collect(); 

        if (in_array('rooms', $featuredOptions)) {
            $featuredRooms = Room::with('images')->where('is_available', true)->latest()->take(3)->get();
        }
        if (in_array('mice', $featuredOptions)) {
            $featuredMice = MiceRoom::with('images')->where('is_available', true)->latest()->take(3)->get();
        }
        if (in_array('restaurants', $featuredOptions)) {
            $featuredRestaurantImages = RestaurantImage::with('restaurant')->latest()->get();
        }
        
        $banners = Banner::where('is_active', true)->orderBy('order')->get();
        
        // 2. TAMBAHKAN BARIS INI
        $heroSliders = HeroSlider::where('is_active', true)->orderBy('order')->get();

        // Terapkan diskon afiliasi pada kamar menggunakan PricingService
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'affiliate']) && $featuredRooms->isNotEmpty()) {
            foreach ($featuredRooms as $room) {
                $pricingService->applyAffiliateDiscount($room);
            }
        }

        // 3. TAMBAHKAN 'heroSliders' KE DALAM COMPACT
        return view('frontend.home', compact('featuredOptions', 'featuredRooms', 'featuredMice', 'featuredRestaurantImages', 'banners', 'heroSliders'));
    }
}