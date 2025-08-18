<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactSetting; // <-- UBAH MODEL INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache; // Gunakan Cache untuk performa

class ContactController extends Controller
{
    /**
     * Menampilkan halaman Contact Us.
     */
    public function index()
    {
        // Ambil data dari cache atau database dari tabel yang benar
        $settings = Cache::remember('contact_settings', 60, function () {
            return ContactSetting::pluck('value', 'key')->all(); // <-- UBAH MODEL INI
        });

        // Tampilkan view dan kirim data settings ke dalamnya
        return view('frontend.contact.index', compact('settings'));
    }
}