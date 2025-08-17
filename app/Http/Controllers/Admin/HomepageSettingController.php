<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomepageSettingController extends Controller
{
    public function edit()
    {
        $settings = HomepageSetting::all()->pluck('value', 'key');
        return view('admin.homepage.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'website_title' => 'nullable|string|max:255',
            'logo_path' => 'nullable|image|max:2048',
            'favicon_path' => 'nullable|image|mimes:jpeg,png,ico,svg|max:2048',
            'featured_display_option' => 'nullable|string',
            'show_about_section' => 'nullable|string',
            'hero_bg_image' => 'nullable|image|max:2048',
            'hero_title' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'about_title' => 'nullable|string|max:255',
            'about_content' => 'nullable|string',
            'hero_text_align' => 'nullable|string',
            'hero_title_font_size' => 'nullable|numeric',
            'hero_title_font_family' => 'nullable|string',
            'hero_subtitle_font_size' => 'nullable|numeric',
            'hero_subtitle_font_family' => 'nullable|string',
            'about_text_align' => 'nullable|string',
            'about_title_font_size' => 'nullable|numeric',
            'about_title_font_family' => 'nullable|string',
            'about_content_font_size' => 'nullable|numeric',
            'about_content_font_family' => 'nullable|string',
            'layout_icon_classroom' => 'nullable|image|max:2048',
            'layout_icon_theatre' => 'nullable|image|max:2048',
            'layout_icon_ushape' => 'nullable|image|max:2048',
            'layout_icon_round' => 'nullable|image|max:2048',
            'layout_icon_board' => 'nullable|image|max:2048',
        ]);

        // Simpan input teks
        $textInputs = $request->except([
            '_token', '_method', 
            'logo_path', 'favicon_path', 'hero_bg_image',
            'show_about_section', 'featured_display_option', 
            'layout_icon_classroom', 'layout_icon_theatre', 
            'layout_icon_ushape', 'layout_icon_round', 'layout_icon_board'
        ]);

        foreach ($textInputs as $key => $value) {
            HomepageSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        
        // Tangani pilihan konten unggulan dari radio button
        HomepageSetting::updateOrCreate(['key' => 'featured_display_option'], ['value' => $request->featured_display_option]);
        
        // Simpan checkbox 'show_about_section'
        HomepageSetting::updateOrCreate(['key' => 'show_about_section'], ['value' => $request->has('show_about_section') ? '1' : '0']);

        // Simpan file yang diunggah
        $files = [
            'logo_path', 'favicon_path', 'hero_bg_image',
            'layout_icon_classroom', 'layout_icon_theatre', 
            'layout_icon_ushape', 'layout_icon_round', 'layout_icon_board'
        ];
        
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $oldPath = HomepageSetting::where('key', $fileKey)->value('value');
                
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                
                // Panggil store() dengan nama folder dan disk
                $path = $file->store('settings', 'public');
                
                // Hanya simpan ke database jika file berhasil disimpan
                if ($path) {
                    HomepageSetting::updateOrCreate(['key' => $fileKey], ['value' => $path]);
                }
            }
        }
        
        return redirect()->back()->with('success', 'Homepage settings updated successfully.');
    }
}