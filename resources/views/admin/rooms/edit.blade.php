<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Edit Room: ') . $room->name }}
            </h2>
            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Room Name</label>
                                <input type="text" name="name" id="name" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('name', $room->name) }}" required>
                            </div>

                            <div>
                                <label for="price" class="block text-sm font-bold text-gray-700 mb-2">Price (IDR)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">Rp</span>
                                    </div>
                                    <input type="number" name="price" id="price" class="pl-10 w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('price', $room->price) }}" required>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="discount_percentage" class="block text-sm font-bold text-gray-700 mb-2">Affiliate Discount (%)</label>
                            <input type="number" name="discount_percentage" id="discount_percentage" class="w-full md:w-1/3 rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('discount_percentage', $room->discount_percentage) }}" min="0" max="100" step="0.01">
                            <p class="text-xs text-gray-500 mt-1">Diskon dalam persen untuk afiliasi (isi 0 jika tidak ada diskon).</p>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" id="description" rows="4" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" required>{{ old('description', $room->description) }}</textarea>
                        </div>

                        <div>
                            <label for="facilities" class="block text-sm font-bold text-gray-700 mb-2">Facilities (one per line)</label>
                            <textarea name="facilities" id="facilities" rows="4" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" required>{{ old('facilities', $room->facilities) }}</textarea>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Images</h3>
                            
                            <div class="mb-6">
                                <label for="images" class="block text-sm font-bold text-gray-700 mb-2">Upload New Images</label>
                                <input type="file" name="images[]" id="images" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all" multiple>
                            </div>

                            @if($room->images->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($room->images as $image)
                                        <div class="relative group rounded-xl overflow-hidden shadow-sm border border-gray-100">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="h-32 w-full object-cover">
                                            <button type="button" 
                                               class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-lg hover:bg-red-600" 
                                               onclick="if(confirm('Are you sure you want to delete this image?')) { document.getElementById('delete-image-{{ $image->id }}').submit(); }">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">No images uploaded yet.</p>
                            @endif
                        </div>
                        
                        <div class="border-t border-gray-100 pt-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_available" id="is_available" value="1" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ $room->is_available ? 'checked' : '' }}>
                                <label for="is_available" class="ml-2 text-sm font-bold text-gray-700">Available for booking</label>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">SEO Settings</h3>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="seo_title" class="block text-sm font-bold text-gray-700 mb-2">SEO Title</label>
                                    <input type="text" name="seo_title" id="seo_title" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('seo_title', $room->seo_title) }}">
                                    <p class="text-xs text-gray-500 mt-1">Optimal 60 characters.</p>
                                </div>
                                <div>
                                    <label for="meta_description" class="block text-sm font-bold text-gray-700 mb-2">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="3" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ old('meta_description', $room->meta_description) }}</textarea>
                                    <p class="text-xs text-gray-500 mt-1">Optimal 160 characters.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.rooms.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Update Room
                            </button>
                        </div>
                    </form>

                    {{-- Hidden Delete Forms --}}
                    @foreach($room->images as $image)
                        <form id="delete-image-{{ $image->id }}" action="{{ route('admin.images.destroy', $image) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>