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
use App\Models\RecreationArea;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();
        $featuredOptions = explode(',', $settings['featured_display_option'] ?? 'rooms');

        $featuredRooms = collect();
        $featuredMice = collect();
        $featuredRestaurantImages = collect();
        $featuredRecreationAreas = collect();

        if (in_array('rooms', $featuredOptions)) {
            $featuredRooms = Room::with('images')->where('is_available', true)->latest()->take(3)->get();
        }
        if (in_array('mice', $featuredOptions)) {
            $featuredMice = MiceRoom::with('images')->where('is_available', true)->latest()->take(3)->get();
        }
        if (in_array('restaurants', $featuredOptions)) {
            $featuredRestaurantImages = RestaurantImage::with('restaurant')->latest()->get();
        }

        // Selalu tampilkan Recreation Areas
        $featuredRecreationAreas = RecreationArea::with('images')->latest()->take(3)->get();
        
        $banners = Banner::where('is_active', true)->orderBy('order')->get();
        
        // 2. TAMBAHKAN BARIS INI
        $heroSliders = HeroSlider::where('is_active', true)->orderBy('order')->get();

        // Terapkan diskon afiliasi pada kamar
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'affiliate']) && $featuredRooms->isNotEmpty()) {
            foreach ($featuredRooms as $room) {
                if ($room->discount_percentage > 0) {
                    $originalPrice = $room->getOriginal('price');
                    $discountAmount = $originalPrice * ($room->discount_percentage / 100);
                    $room->price = $originalPrice - $discountAmount;
                }
            }
        }

        // 3. TAMBAHKAN 'heroSliders' KE DALAM COMPACT
        return view('frontend.home', compact('featuredOptions', 'featuredRooms', 'featuredMice', 'featuredRestaurantImages', 'featuredRecreationAreas', 'banners', 'heroSliders'));
    }
}