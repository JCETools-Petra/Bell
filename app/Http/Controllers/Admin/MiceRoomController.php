<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiceRoom;
use App\Models\Image; // Model Image wajib di-import
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MiceRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $miceRooms = MiceRoom::latest()->paginate(10);
        return view('admin.mice.index', compact('miceRooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:mice_rooms',
            'description' => 'required|string',
            'capacity' => 'nullable|integer', // Validasi Capacity
            'dimension' => 'nullable|string',
            'size_sqm' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'specifications.*.key' => 'nullable|string',
            'specifications.*.value' => 'nullable|string',
            'specifications.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan data dasar (Pastikan 'capacity' masuk disini)
        $data = $request->only([
            'name', 'slug', 'description', 'meta_title', 'meta_description',
            'dimension', 'size_sqm', 'capacity', 'rate_details', 'facilities'
        ]);
        
        $data['is_available'] = $request->has('is_available') ? 1 : 0;
        
        $miceRoom = new MiceRoom($data);

        // Logic Specifications
        $specifications = [];
        if ($request->input('specifications')) {
            foreach ($request->input('specifications') as $index => $specificationData) {
                if (!empty($specificationData['key'])) { // Minimal key harus ada
                    $newSpecification = [
                        'key' => $specificationData['key'],
                        'value' => $specificationData['value'] ?? '',
                        'image' => null,
                    ];

                    if ($request->hasFile("specifications.{$index}.image")) {
                        $path = $request->file("specifications.{$index}.image")->store('mice/specifications', 'public');
                        $newSpecification['image'] = Storage::url($path);
                    }

                    $specifications[] = $newSpecification;
                }
            }
        }
        // FIX: Don't json_encode because model cast will do it automatically
        $miceRoom->specifications = $specifications;
        $miceRoom->save();

        // Logic Images Gallery
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Simpan ke folder 'mice' di disk 'public'
                $path = $image->store('mice', 'public'); 
                
                // Simpan URL lengkap ke database
                $miceRoom->images()->create(['path' => Storage::url($path)]);
            }
        }

        return redirect()->route('admin.mice.index')->with('success', 'MICE room created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MiceRoom $mouse)
    {
        // Tetapkan ke variabel $miceRoom agar lebih mudah dibaca
        $miceRoom = $mouse;

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:mice_rooms,slug,' . $miceRoom->id,
            'description' => 'required|string',
            'capacity' => 'nullable|integer', // Validasi Capacity
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'specifications.*.key' => 'nullable|string',
            'specifications.*.value' => 'nullable|string',
            'specifications.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 1. Update Data Text Utama
        // Pastikan 'capacity' ada di dalam only()
        $data = $request->only([
            'name', 'slug', 'description', 'meta_title', 'meta_description',
            'dimension', 'size_sqm', 'capacity', 'rate_details', 'facilities'
        ]);
        
        $data['is_available'] = $request->has('is_available') ? 1 : 0;

        $miceRoom->update($data);

        // 2. LOGIKA HAPUS FOTO (Checkboxes)
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = Image::find($imageId);
                if ($image) {
                    // Hapus file fisik
                    $pathToDelete = str_replace('/storage/', '', $image->path); 
                    
                    if (Storage::disk('public')->exists($pathToDelete)) {
                        Storage::disk('public')->delete($pathToDelete);
                    } elseif (Storage::exists($pathToDelete)) {
                        Storage::delete($pathToDelete);
                    }
                    
                    // Hapus record DB
                    $image->delete();
                }
            }
        }

        // 3. Logic Specifications Update
        $specifications = [];
        if ($request->input('specifications')) {
            foreach ($request->input('specifications') as $index => $specificationData) {
                 if (!empty($specificationData['key'])) {
                    $newSpecification = [
                        'key' => $specificationData['key'],
                        'value' => $specificationData['value'] ?? '',
                        'image' => $specificationData['image_path'] ?? null,
                    ];

                    if ($request->hasFile("specifications.{$index}.image")) {
                        if (!empty($newSpecification['image'])) {
                            $oldPath = str_replace('/storage/', '', $newSpecification['image']);
                            if (Storage::disk('public')->exists($oldPath)) {
                                Storage::disk('public')->delete($oldPath);
                            }
                        }

                        $path = $request->file("specifications.{$index}.image")->store('mice/specifications', 'public');
                        $newSpecification['image'] = Storage::url($path);
                    }

                    $specifications[] = $newSpecification;
                }
            }
        }

        // FIX: Don't json_encode because model cast will do it automatically
        $miceRoom->specifications = $specifications;
        $miceRoom->save();

        // 4. Upload Foto Baru (Gallery)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Gunakan folder 'mice' di disk 'public' agar konsisten dengan store()
                $path = $image->store('mice', 'public');
                
                // Simpan URL lengkap
                $miceRoom->images()->create(['path' => Storage::url($path)]);
            }
        }

        return redirect()->route('admin.mice.index')->with('success', 'Mice Room berhasil diperbarui!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MiceRoom $mouse)
    {
        return view('admin.mice.edit', ['miceRoom' => $mouse]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MiceRoom $mouse)
    {
        // Hapus semua file gambar yang berelasi dari storage
        foreach ($mouse->images as $image) {
            $pathToDelete = str_replace('/storage/', '', $image->path);
            if(Storage::disk('public')->exists($pathToDelete)){
                 Storage::disk('public')->delete($pathToDelete);
            }
            $image->delete();
        }
        
        // Hapus record mice room
        $mouse->delete();
        
        return redirect()->route('admin.mice.index')->with('success', 'MICE Room deleted successfully.');
    }
}