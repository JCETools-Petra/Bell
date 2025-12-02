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
        $this->authorize('viewAny', MiceRoom::class);

        $miceRooms = MiceRoom::latest()->paginate(10);
        return view('admin.mice.index', compact('miceRooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', MiceRoom::class);

        return view('admin.mice.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', MiceRoom::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:mice_rooms',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'specifications.*.key' => 'nullable|string',
            'specifications.*.value' => 'nullable|string',
            'specifications.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $miceRoom = new MiceRoom($request->only('name', 'slug', 'description', 'seo_title', 'meta_description'));

        $specifications = [];
        if ($request->input('specifications')) {
            foreach ($request->input('specifications') as $index => $specificationData) {
                if (!empty($specificationData['key']) && !empty($specificationData['value'])) {
                    $newSpecification = [
                        'key' => $specificationData['key'],
                        'value' => $specificationData['value'],
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
        $miceRoom->specifications = json_encode($specifications);
        $miceRoom->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('mice', 'public');
                $miceRoom->images()->create(['path' => $path]);
            }
        }

        return redirect()->route('admin.mice.index')->with('success', 'MICE room created successfully.');
    }

    public function update(Request $request, MiceRoom $mouse) // Ubah $miceRoom jadi $mouse
    {
        $this->authorize('update', $mouse);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:mice_rooms,slug,' . $mouse->id, // Gunakan $mouse->id
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'specifications.*.key' => 'nullable|string',
            'specifications.*.value' => 'nullable|string',
            'specifications.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Gunakan $mouse untuk update
        $mouse->update($request->only('name', 'slug', 'description', 'seo_title', 'meta_description'));

        $specifications = [];
        if ($request->input('specifications')) {
            foreach ($request->input('specifications') as $index => $specificationData) {
                 if (!empty($specificationData['key']) && !empty($specificationData['value'])) {
                    $newSpecification = [
                        'key' => $specificationData['key'],
                        'value' => $specificationData['value'],
                        'image' => $specificationData['image_path'] ?? null,
                    ];

                    if ($request->hasFile("specifications.{$index}.image")) {
                        if ($newSpecification['image']) {
                            $oldImagePath = str_replace('/storage/', '', $newSpecification['image']);
                            Storage::disk('public')->delete($oldImagePath);
                        }

                        $path = $request->file("specifications.{$index}.image")->store('mice/specifications', 'public');
                        $newSpecification['image'] = Storage::url($path);
                    }

                    $specifications[] = $newSpecification;
                }
            }
        }

        $mouse->specifications = json_encode($specifications);
        $mouse->save();

        if ($request->hasFile('images')) {
            \Illuminate\Support\Facades\Log::info('MiceRoomController update: Images found', ['count' => count($request->file('images'))]);
            foreach ($request->file('images') as $image) {
                $path = $image->store('mice', 'public');
                \Illuminate\Support\Facades\Log::info('MiceRoomController update: Image stored', ['path' => $path]);
                $mouse->images()->create(['path' => $path]);
            }
        } else {
            \Illuminate\Support\Facades\Log::info('MiceRoomController update: No images found in request');
        }

        return redirect()->route('admin.mice.index')->with('success', 'MICE room updated successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MiceRoom $mouse)
    {
        $this->authorize('update', $mouse);

        return view('admin.mice.edit', ['miceRoom' => $mouse]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MiceRoom $mouse)
    {
        $this->authorize('delete', $mouse);

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