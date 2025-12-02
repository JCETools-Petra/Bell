<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\MiceRoom;
use App\Models\HeroSlider;
use App\Models\Restaurant;
use App\Models\RecreationArea;
use App\Models\Setting; // <--- UBAH INI: Gunakan model Setting, bukan HomepageSetting
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Hero Sliders
        $heroSliders = HeroSlider::where('is_active', true)
            ->orderBy('order')
            ->get();

        // 2. Featured Rooms (Kamar)
        $rooms = Room::with('images')
            ->where('is_available', true)
            ->latest()
            ->take(3)
            ->get();

        // 3. Featured MICE
        $miceRooms = MiceRoom::with('images')
            ->where('is_available', true)
            ->latest()
            ->take(3)
            ->get();

        // 4. Restaurants
        $restaurants = Restaurant::with('images')
            ->latest()
            ->take(3)
            ->get();

        // 5. Recreation Areas
        $recreationAreas = RecreationArea::with('images')
            ->latest()
            ->take(3)
            ->get();

        // ==========================================
        // 6. PERBAIKAN RUNNING TEXT (AMBIL DARI SETTINGS)
        // ==========================================
        
        // Menggunakan Model 'Setting' (tabel settings) sesuai Admin Panel Anda
        // Key di Admin: 'running_text_enabled' & 'running_text_content'
        $runningTextStatus = Setting::where('key', 'running_text_enabled')->value('value'); 
        $runningTextContent = Setting::where('key', 'running_text_content')->value('value');

        // Logika Diskon
        if (Auth::check() && in_array(Auth::user()->role, ['admin', 'affiliate']) && $rooms->isNotEmpty()) {
            foreach ($rooms as $room) {
                if ($room->discount_percentage > 0) {
                    $originalPrice = $room->getOriginal('price');
                    $discountAmount = $originalPrice * ($room->discount_percentage / 100);
                    $room->price = $originalPrice - $discountAmount;
                }
            }
        }

        // Kirim semua variabel ke view
        return view('frontend.home', compact(
            'heroSliders', 
            'rooms', 
            'miceRooms', 
            'restaurants', 
            'recreationAreas',
            'runningTextStatus',   // Variabel ini sekarang berisi data yang benar dari tabel settings
            'runningTextContent'
        ));
    }
}