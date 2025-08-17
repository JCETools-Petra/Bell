<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->paginate(10);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'facilities' => 'required|string',
            'is_available' => 'boolean',
            'images' => 'nullable|array', // Validasi untuk array gambar
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi untuk setiap file
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_available'] = $request->has('is_available');
        
        // Buat room dulu tanpa gambar
        $room = Room::create($validated);

        // Jika ada gambar yang diupload, proses satu per satu
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('rooms', 'public');
                $room->images()->create(['path' => $path]); // Buat record gambar yang berelasi dengan room
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string',
            'facilities' => 'required|string',
            'is_available' => 'boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $validated['slug'] = Str::slug($request->name);
        $validated['is_available'] = $request->has('is_available');

        $room->update($validated);

        // Proses jika ada gambar baru yang diupload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('rooms', 'public');
                $room->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        // Hapus semua gambar terkait dari storage
        foreach ($room->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        
        // Hapus record room (dan relasi gambar akan otomatis terhapus jika di-setup di DB)
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}