<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use App\Models\MiceRoom;
use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
     public function index()
    {
        $settings = HomepageSetting::all()->pluck('value', 'key');
        $displayOption = $settings['featured_display_option'] ?? 'rooms';

        $featuredRooms = collect(); // Buat koleksi kosong
        $featuredMice = collect(); // Buat koleksi kosong

        if ($displayOption === 'rooms') {
            $featuredRooms = Room::where('is_available', true)->latest()->take(3)->get();
        } elseif ($displayOption === 'mice') {
            $featuredMice = MiceRoom::where('is_available', true)->latest()->take(3)->get();
        } elseif ($displayOption === 'both') {
            // DIUBAH DARI take(2) MENJADI take(3)
            $featuredRooms = Room::where('is_available', true)->latest()->take(3)->get();
            $featuredMice = MiceRoom::where('is_available', true)->latest()->take(3)->get();
        }

        return view('frontend.home', compact('settings', 'displayOption', 'featuredRooms', 'featuredMice'));
    }
}