<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MiceRoom;
use Illuminate\Http\Request;
use App\Models\HomepageSetting; 

class MiceController extends Controller
{
    public function index()
    {
        // 2. AMBIL DATA SETTINGS
        $settings = HomepageSetting::pluck('value', 'key')->all();
        
        $miceRooms = MiceRoom::where('is_available', true)->paginate(10);
        
        // 3. KIRIM DATA SETTINGS KE VIEW
        return view('frontend.mice.index', compact('miceRooms', 'settings'));
    }

    public function show($slug)
    {
        // 1. TAMBAHKAN BARIS INI untuk mengambil data settings
        $settings = HomepageSetting::pluck('value', 'key')->all();

        $mice = MiceRoom::where('slug', $slug)->firstOrFail();
        
        // 2. TAMBAHKAN 'settings' untuk dikirim ke view
        return view('frontend.mice.show', compact('mice', 'settings'));
    }
}