<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Models\MiceRoom;
use App\Models\Room;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index()
    {
        $settings = HomepageSetting::all()->pluck('value', 'key');
        
        // Mengubah string pilihan menjadi array untuk multiple choice
        $featuredOptions = explode(',', $settings['featured_display_option'] ?? 'rooms');

        $featuredRooms = collect();
        $featuredMice = collect();
        $featuredRestaurants = collect();

        if (in_array('rooms', $featuredOptions)) {
            $featuredRooms = Room::with('images')->where('is_available', true)->latest()->take(3)->get();
        }
        
        if (in_array('mice', $featuredOptions)) {
            $featuredMice = MiceRoom::with('images')->where('is_available', true)->latest()->take(3)->get();
        } 
        
        if (in_array('restaurants', $featuredOptions)) {
            $featuredRestaurants = Restaurant::with('images')->latest()->take(3)->get();
        }
        
        return view('frontend.home', compact('settings', 'featuredOptions', 'featuredRooms', 'featuredMice', 'featuredRestaurants'));
    }
}