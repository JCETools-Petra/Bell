<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Room: ') . $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Room Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name', $room->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="price" class="block text-sm font-medium text-gray-700">Price (IDR)</label>
                            <input type="number" name="price" id="price" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('price', $room->price) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Affiliate Discount (%)</label>
                            <input type="number" name="discount_percentage" id="discount_percentage" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('discount_percentage', $room->discount_percentage) }}" min="0" max="100" step="0.01">
                             <p class="text-xs text-gray-500 mt-1">Diskon dalam persen untuk afiliasi (isi 0 jika tidak ada diskon).</p>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('description', $room->description) }}</textarea>
                        </div>

                         <div class="mb-4">
                            <label for="facilities" class="block text-sm font-medium text-gray-700">Facilities (one per line)</label>
                            <textarea name="facilities" id="facilities" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('facilities', $room->facilities) }}</textarea>
                        </div>

                        <hr class="my-6">
                        
                        {{-- IMAGE MANAGEMENT --}}
                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700">Upload New Images</label>
                            <input type="file" name="images[]" id="images" class="mt-1 block w-full" multiple>
                        </div>
                        
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900">Existing Images</h3>
                            @if($room->images->isNotEmpty())
                                <p class="text-sm text-gray-500 mb-4">Centang kotak "Hapus" pada gambar yang ingin dibuang, lalu klik tombol Update.</p>
                                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($room->images as $image)
                                        <div class="relative group border rounded p-2 bg-gray-50">
                                            {{-- PERBAIKAN: Logika Path Gambar Pintar --}}
                                            <div class="aspect-w-16 aspect-h-9 overflow-hidden rounded-md">
                                                <img src="{{ Str::contains($image->path, 'storage/') ? asset($image->path) : asset('storage/' . str_replace('public/', '', $image->path)) }}" 
                                                     class="object-cover w-full h-32"
                                                     alt="Room Image"
                                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=No+Image';">
                                            </div>
                                            
                                            {{-- PERBAIKAN: Checkbox Hapus (menggantikan tombol link) --}}
                                            <div class="mt-2 flex items-center justify-center bg-white p-1 rounded border border-gray-200">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="img-{{ $image->id }}" class="rounded border-red-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 cursor-pointer">
                                                <label for="img-{{ $image->id }}" class="ml-2 text-sm text-red-600 cursor-pointer font-bold">Hapus</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 col-span-full mt-2">No images uploaded yet.</p>
                            @endif
                        </div>
                        
                        <hr class="my-6">
                        
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_available" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" {{ $room->is_available ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Available for booking</span>
                            </label>
                        </div>

                        <hr class="my-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Settings</h3>
                            <div class="mb-4">
                                <label for="seo_title" class="block text-sm font-medium text-gray-700">SEO Title</label>
                                <input type="text" name="seo_title" id="seo_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('seo_title', $room->seo_title) }}">
                                <p class="text-xs text-gray-500 mt-1">Judul yang akan tampil di tab browser dan hasil pencarian Google (optimal 60 karakter).</p>
                            </div>
                            <div class="mb-4">
                                <label for="meta_description" class="block text-sm font-medium text-gray-700">Meta Description</label>
                                <textarea name="meta_description" id="meta_description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('meta_description', $room->meta_description) }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Deskripsi singkat yang akan tampil di hasil pencarian Google (optimal 160 karakter).</p>
                            </div>

                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-brand-red text-white rounded-md hover:opacity-90 transition-opacity">Update Room</button>
                            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:opacity-90 transition-opacity">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>