<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // Gunakan Model yang baru
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman formulir pengaturan.
     */
    public function index()
    {
        // Ambil semua data dari tabel settings dan ubah menjadi array
        $settings = Setting::pluck('value', 'key')->all();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Menyimpan atau memperbarui semua pengaturan.
     */
    public function update(Request $request)
    {
        // Validasi semua input yang mungkin ada
        $validatedData = $request->validate([
            // General
            'website_title' => 'required|string|max:255',
            'logo_height' => 'required|integer|min:20|max:100',
            'show_logo_text' => 'sometimes|boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
            // Hero Section
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            // Contact
            'contact_address' => 'nullable|string',
            'contact_phone' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'contact_facebook' => 'nullable|url',
            'contact_instagram' => 'nullable|url',
            'contact_linkedin' => 'nullable|url',
            'contact_youtube' => 'nullable|url',
            'contact_tiktok' => 'nullable|url',
            // Legal
            'terms_and_conditions' => 'nullable|string',
            'contact_maps_embed' => 'nullable|string',
        ]);

        // Proses input boolean (checkbox)
        $validatedData['show_logo_text'] = $request->has('show_logo_text') ? '1' : '0';

        // Proses file upload (logo, favicon, hero image)
        $filesToUpload = ['logo', 'favicon', 'hero_image'];
        foreach ($filesToUpload as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Hapus file lama jika ada
                $oldPath = Setting::where('key', $fileKey . '_path')->value('value');
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
                
                // Simpan file baru dan simpan path-nya
                $path = $request->file($fileKey)->store('settings', 'public');
                $validatedData[$fileKey . '_path'] = $path;
            }
        }

        // Hapus key file dari array agar tidak tersimpan sebagai setting biasa
        unset($validatedData['logo'], $validatedData['favicon'], $validatedData['hero_image']);

        // Simpan setiap data ke database menggunakan metode updateOrCreate
        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        Cache::forget('site_settings');
        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}