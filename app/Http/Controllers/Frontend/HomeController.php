<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Room;
use App\Models\MiceRoom;
use App\Models\Restaurant;
use App\Models\Banner;

class HomeController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->all();

        $featuredOptions = explode(',', $settings['featured_display_option'] ?? 'rooms');

        $featuredRooms = collect();
        $featuredMice = collect();
        $featuredRestaurants = collect();

        if (in_array('rooms', $featuredOptions)) {
            $featuredRooms = Room::with('images')->where('is_available', true)->latest()->take(3)->get();
        }
        if (in_array('mice', $featuredOptions)) {
            $featuredMice = MiceRoom::where('is_available', true)->latest()->take(3)->get();
        }
        if (in_array('restaurants', $featuredOptions)) {
            $featuredRestaurants = Restaurant::latest()->take(3)->get();
        }
        
        $banners = Banner::where('is_active', true)->orderBy('order')->get();

        // PERBAIKI BARIS INI: Tambahkan 'featuredOptions' ke dalam compact()
        return view('frontend.home', compact('featuredOptions', 'featuredRooms', 'featuredMice', 'featuredRestaurants', 'banners'));
    }
}