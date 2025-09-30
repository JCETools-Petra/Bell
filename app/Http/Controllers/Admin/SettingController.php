<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman formulir pengaturan.
     */
    public function index()
    {
        // Ambil semua pengaturan dalam bentuk [key => value]
        $settings = Setting::pluck('value', 'key')->all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Menyimpan atau memperbarui semua pengaturan.
     */
    public function update(Request $request)
    {
        // 1) Validasi SEMUA input yang BUKAN checkbox
        $validatedData = $request->validate([
            // General
            'website_title' => 'required|string|max:255',
            'logo_height' => 'required|integer|min:20|max:100',
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
            'contact_maps_embed' => 'nullable|string',

            // Legal
            'terms_and_conditions' => 'nullable|string',

            // Midtrans (non-checkbox)
            'midtrans_merchant_id' => 'required|string|max:255',
            'midtrans_client_key' => 'required|string|max:255',
            'midtrans_server_key' => 'required|string|max:255',

            // WhatsApp Templates
            'whatsapp_customer_message' => 'required|string',
            'whatsapp_admin_message' => 'required|string',

            // Booking Method
            'booking_method' => 'required|in:direct,manual',
            'running_text_content' => 'nullable|string|max:255',
            'running_text_url' => 'nullable|url|max:255',
        ]);

        // 2) Proses file upload (logo, favicon, hero image)
        $filesToUpload = ['logo', 'favicon', 'hero_image'];
        foreach ($filesToUpload as $fileKey) {
            if ($request->hasFile($fileKey)) {
                // Hapus file lama jika ada
                $oldPath = Setting::where('key', $fileKey . '_path')->value('value');
                if ($oldPath) {
                    Storage::disk('public')->delete($oldPath);
                }
                // Simpan file baru
                $path = $request->file($fileKey)->store('settings', 'public');
                // Catat path ke dalam data yang akan disimpan
                $validatedData[$fileKey . '_path'] = $path;
            }
        }

        // Singkirkan field file supaya tidak ikut disimpan sebagai string
        unset($validatedData['logo'], $validatedData['favicon'], $validatedData['hero_image']);

        // 3) Simpan semua data non-checkbox yang sudah divalidasi
        foreach ($validatedData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '']
            );
        }

        // ==========================================================
        // 4) Simpan semua CHECKBOX dengan $request->boolean()
        //    (hidden input value="0" akan terbaca sebagai false)
        // ==========================================================
        $checkboxes = [
            'show_logo_text',
            'midtrans_is_production',
            'running_text_enabled',
        ];

        foreach ($checkboxes as $key) {
            $value = $request->boolean($key) ? '1' : '0';
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        // ==========================================================

        // 5) Hapus cache & redirect
        Cache::forget('site_settings');

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
