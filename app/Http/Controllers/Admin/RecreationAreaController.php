<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RecreationArea;
use App\Models\RecreationAreaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RecreationAreaController extends Controller
{
    public function index()
    {
        $recreationAreas = RecreationArea::with('images')->orderBy('order')->get();
        return view('admin.recreation_areas.index', compact('recreationAreas'));
    }

    public function create()
    {
        return view('admin.recreation_areas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $recreationArea = RecreationArea::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
            'order' => $validated['order'] ?? 0,
        ]);

        // Upload dan simpan setiap gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                // Simpan fisik file
                $path = $image->store('recreation_areas', 'public');

                // PERBAIKAN: Gunakan Storage::url agar path di DB konsisten (/storage/...)
                $recreationArea->images()->create([
                    'path' => Storage::url($path), 
                    'caption' => $request->captions[$index] ?? null,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.recreation-areas.index')->with('success', 'Recreation Area berhasil ditambahkan!');
    }

    public function edit(RecreationArea $recreationArea)
    {
        return view('admin.recreation_areas.edit', compact('recreationArea'));
    }

    public function update(Request $request, RecreationArea $recreationArea)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
            'images' => 'nullable|array',
            'images.*' => 'image|max:2048',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $recreationArea->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'is_active' => $request->has('is_active') ? true : false,
            'order' => $validated['order'] ?? 0,
        ]);

        // Upload dan simpan gambar baru
        if ($request->hasFile('images')) {
            $currentImageCount = $recreationArea->images()->count();
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('recreation_areas', 'public');

                // PERBAIKAN: Gunakan Storage::url di sini juga
                $recreationArea->images()->create([
                    'path' => Storage::url($path),
                    'caption' => $request->captions[$index] ?? null,
                    'order' => $currentImageCount + $index,
                ]);
            }
        }

        return redirect()->route('admin.recreation-areas.index')->with('success', 'Recreation Area berhasil diupdate!');
    }

    public function destroy(RecreationArea $recreationArea)
    {
        foreach ($recreationArea->images as $image) {
            // Bersihkan path untuk penghapusan fisik
            $pathToDelete = str_replace('/storage/', '', $image->path);
            if (Storage::disk('public')->exists($pathToDelete)) {
                Storage::disk('public')->delete($pathToDelete);
            }
            $image->delete();
        }

        $recreationArea->delete();

        return redirect()->route('admin.recreation-areas.index')->with('success', 'Recreation Area berhasil dihapus!');
    }

    public function destroyImage(RecreationAreaImage $image)
    {
        $pathToDelete = str_replace('/storage/', '', $image->path);
        if (Storage::disk('public')->exists($pathToDelete)) {
            Storage::disk('public')->delete($pathToDelete);
        }
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus!');
    }
}