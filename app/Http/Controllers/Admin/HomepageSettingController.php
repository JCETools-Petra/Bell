<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageSettingController extends Controller
{
    public function edit()
    {
        $settings = HomepageSetting::all()->pluck('value', 'key');
        return view('admin.homepage.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        // Ambil semua data kecuali token, method, dan file-file
        $data = $request->except([
            '_token', '_method', 'hero_bg_image', 'layout_icon_classroom', 'layout_icon_theatre', 
            'layout_icon_ushape', 'layout_icon_round', 'layout_icon_board'
        ]);

        $showAboutValue = $request->has('show_about_section') ? '1' : '0';
        HomepageSetting::updateOrCreate(['key' => 'show_about_section'], ['value' => $showAboutValue]);

        foreach ($data as $key => $value) {
            HomepageSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Daftar file yang akan di-handle
        $filesToProcess = [
            'hero_bg_image', 'layout_icon_classroom', 'layout_icon_theatre', 
            'layout_icon_ushape', 'layout_icon_round', 'layout_icon_board'
        ];

        foreach ($filesToProcess as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $oldImage = HomepageSetting::where('key', $fileKey)->first();
                if ($oldImage && $oldImage->value) {
                    Storage::disk('public')->delete($oldImage->value);
                }

                $path = $request->file($fileKey)->store('settings', 'public');
                
                HomepageSetting::updateOrCreate(
                    ['key' => $fileKey],
                    ['value' => $path]
                );
            }
        }

        return redirect()->back()->with('success', 'Homepage settings updated successfully.');
    }
}