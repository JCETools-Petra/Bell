<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MiceRoom;
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dimension' => 'nullable|string|max:255',
            'size_sqm' => 'nullable|string|max:255',
            'rate_details' => 'required|string',
            'capacity_classroom' => 'nullable|integer',
            'capacity_theatre' => 'nullable|integer',
            'capacity_ushape' => 'nullable|integer',
            'capacity_round' => 'nullable|integer',
            'capacity_board' => 'nullable|integer',
            'description' => 'required|string',
            'facilities' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_available'] = $request->has('is_available');

        $mice = MiceRoom::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('mice', 'public');
                $mice->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.mice.index')->with('success', 'MICE Room created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MiceRoom $mouse)
    {
        return view('admin.mice.edit', ['miceRoom' => $mouse]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MiceRoom $mouse)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dimension' => 'nullable|string|max:255',
            'size_sqm' => 'nullable|string|max:255',
            'rate_details' => 'required|string',
            'capacity_classroom' => 'nullable|integer',
            'capacity_theatre' => 'nullable|integer',
            'capacity_ushape' => 'nullable|integer',
            'capacity_round' => 'nullable|integer',
            'capacity_board' => 'nullable|integer',
            'description' => 'required|string',
            'facilities' => 'required|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($request->name);
        $validated['is_available'] = $request->has('is_available');

        $mouse->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('mice', 'public');
                $mouse->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.mice.index')->with('success', 'MICE Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MiceRoom $mouse)
    {
        // Hapus semua file gambar yang berelasi dari storage
        foreach ($mouse->images as $image) {
            Storage::disk('public')->delete($image->path);
            $image->delete(); // Hapus record gambar dari tabel images
        }
        
        // Hapus record mice room
        $mouse->delete();
        
        return redirect()->route('admin.mice.index')->with('success', 'MICE Room deleted successfully.');
    }
}