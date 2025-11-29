<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit MICE Room: ') . $miceRoom->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Display Validation Errors --}}
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong>
                            <span class="block sm:inline">There were some problems with your input.</span>
                            <ul class="mt-3 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.mice.update', $miceRoom->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        {{-- Nama, Slug --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">MICE Room Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name', $miceRoom->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="block text-sm font-medium text-gray-700">Slug (URL-friendly name)</label>
                            <input type="text" name="slug" id="slug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('slug', $miceRoom->slug) }}" required>
                            <p class="mt-1 text-sm text-gray-500">This will be used in the URL. Example: grand-ballroom</p>
                        </div>

                        {{-- Dimension, Size, Capacity (3 Kolom) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                            <div>
                                <label for="dimension" class="block text-sm font-medium text-gray-700">Dimension (e.g., 15 x 16)</label>
                                <input type="text" name="dimension" id="dimension" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('dimension', $miceRoom->dimension) }}">
                            </div>
                            <div>
                                <label for="size_sqm" class="block text-sm font-medium text-gray-700">Size in SQM² (e.g., 240 M²)</label>
                                <input type="text" name="size_sqm" id="size_sqm" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('size_sqm', $miceRoom->size_sqm) }}">
                            </div>
                            <div>
                                <label for="capacity" class="block text-sm font-medium text-gray-700">Total Capacity (Pax)</label>
                                <input type="number" name="capacity" id="capacity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('capacity', $miceRoom->capacity) }}">
                            </div>
                        </div>

                        <hr class="my-6">

                        {{-- Spesifikasi Layout Dinamis --}}
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Layout Specifications</h3>
                        <div id="specifications-container" class="space-y-4">
                            {{-- PERBAIKAN: Handle Specifications (Array vs JSON String) --}}
                            @php
                                $specs = $miceRoom->specifications;
                                // Jika masih string (JSON), decode dulu. Jika sudah array (karena Model casting), biarkan.
                                if (is_string($specs)) {
                                    $specs = json_decode($specs, true);
                                }
                                // Pastikan tipe akhirnya adalah array untuk di-loop
                                $specs = is_array($specs) ? $specs : [];
                            @endphp

                            @foreach ($specs as $index => $spec)
                                <div class="grid grid-cols-1 md:grid-cols-10 gap-4 specification-row items-center bg-gray-50 p-4 rounded">
                                    <div class="md:col-span-3">
                                        <label class="text-sm font-medium text-gray-700">Layout Name</label>
                                        <input type="text" name="specifications[{{ $index }}][key]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Classroom" value="{{ $spec['key'] ?? '' }}">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="text-sm font-medium text-gray-700">Capacity (Pax)</label>
                                        <input type="text" name="specifications[{{ $index }}][value]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., 150 Pax" value="{{ $spec['value'] ?? '' }}">
                                    </div>
                                    <div class="md:col-span-4">
                                        <label class="text-sm font-medium text-gray-700">Layout Image</label>
                                        <input type="file" name="specifications[{{ $index }}][image]" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                                        <input type="hidden" name="specifications[{{ $index }}][image_path]" value="{{ $spec['image'] ?? '' }}">
                                        @if(!empty($spec['image']))
                                            <div class="mt-2">
                                                {{-- PERBAIKAN: Logika Path Gambar Pintar --}}
                                                <img src="{{ Str::contains($spec['image'], 'storage/') ? asset($spec['image']) : asset('storage/' . str_replace('public/', '', $spec['image'])) }}" 
                                                     alt="{{ $spec['key'] ?? '' }}" 
                                                     class="h-10 w-10 object-cover rounded border"
                                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/50?text=Icon';">
                                            </div>
                                        @endif
                                    </div>
                                    <div class="md:col-span-1 pt-6 text-right">
                                        <button type="button" class="text-red-600 hover:text-red-800 font-bold remove-specification">X</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <button type="button" id="add-specification" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Add New Layout</button>
                        
                        <hr class="my-6">

                        {{-- Rate, Deskripsi, Fasilitas --}}
                        <div class="mb-4">
                            <label for="rate_details" class="block text-sm font-medium text-gray-700">Rate Details</label>
                            <textarea name="rate_details" id="rate_details" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('rate_details', $miceRoom->rate_details) }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $miceRoom->description) }}</textarea>
                        </div>
                         <div class="mb-4">
                            <label for="facilities" class="block text-sm font-medium text-gray-700">Facilities (one per line)</label>
                            <textarea name="facilities" id="facilities" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('facilities', $miceRoom->facilities) }}</textarea>
                        </div>

                        <hr class="my-6">
                        
                        {{-- GAMBAR MANAGEMENT --}}
                        <div class="mb-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <label for="images" class="block text-lg font-medium text-gray-900 mb-2">Manage Images</label>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Upload New Images</label>
                                <input type="file" name="images[]" id="images" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" multiple>
                                <p class="text-xs text-gray-500 mt-1">You can select multiple files.</p>
                            </div>

                            @if($miceRoom->images && $miceRoom->images->count() > 0)
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Existing Images (Check box to delete)</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                    @foreach($miceRoom->images as $image)
                                        <div class="relative group border rounded-lg p-2 bg-white shadow-sm hover:shadow-md transition-shadow">
                                            <div class="aspect-w-16 aspect-h-9 mb-2 overflow-hidden rounded">
                                                {{-- PERBAIKAN: Logika Path Gambar Pintar --}}
                                                <img src="{{ Str::contains($image->path, 'storage/') ? asset($image->path) : asset('storage/' . str_replace('public/', '', $image->path)) }}" 
                                                     class="object-cover w-full h-32 rounded" 
                                                     onerror="this.onerror=null;this.src='https://via.placeholder.com/150?text=No+Image';">
                                            </div>
                                            <div class="flex items-center justify-center bg-red-50 p-2 rounded cursor-pointer hover:bg-red-100 transition-colors">
                                                <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="img-{{ $image->id }}" class="rounded border-red-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 h-5 w-5 cursor-pointer">
                                                <label for="img-{{ $image->id }}" class="ml-2 text-sm font-bold text-red-700 cursor-pointer select-none">DELETE</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic text-sm">No images uploaded yet.</p>
                            @endif
                        </div>
                        
                        <hr class="my-6">

                        {{-- Status & Tombol Submit --}}
                        <div class="flex items-center justify-between">
                            <div class="mb-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_available" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm h-5 w-5" {{ $miceRoom->is_available ? 'checked' : '' }}>
                                    <span class="ml-2 text-md text-gray-700 font-medium">Available for booking</span>
                                </label>
                            </div>
                            
                            <div>
                                <a href="{{ route('admin.mice.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 mr-2">Cancel</a>
                                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 shadow-lg transition-transform transform hover:-translate-y-0.5">Update MICE Room</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-generate slug from name
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');

            if(nameInput && slugInput) {
                nameInput.addEventListener('input', function() {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    slugInput.value = slug;
                });
            }

            // PERBAIKAN: Hitung index berdasarkan data yang ada
            @php
                $existingSpecs = is_string($miceRoom->specifications) 
                    ? json_decode($miceRoom->specifications, true) 
                    : $miceRoom->specifications;
                $count = is_array($existingSpecs) ? count($existingSpecs) : 0;
            @endphp
            
            let specificationIndex = {{ $count }};

            const addBtn = document.getElementById('add-specification');
            if(addBtn) {
                addBtn.addEventListener('click', function () {
                    const container = document.getElementById('specifications-container');
                    const newRow = document.createElement('div');
                    newRow.className = 'grid grid-cols-1 md:grid-cols-10 gap-4 specification-row items-center bg-gray-50 p-4 rounded mt-4';
                    newRow.innerHTML = `
                        <div class="md:col-span-3">
                            <label class="text-sm font-medium text-gray-700">Layout Name</label>
                            <input type="text" name="specifications[${specificationIndex}][key]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., Classroom">
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm font-medium text-gray-700">Capacity (Pax)</label>
                            <input type="text" name="specifications[${specificationIndex}][value]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g., 150 Pax">
                        </div>
                        <div class="md:col-span-4">
                            <label class="text-sm font-medium text-gray-700">Layout Image</label>
                            <input type="file" name="specifications[${specificationIndex}][image]" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                        </div>
                        <div class="md:col-span-1 pt-6 text-right">
                            <button type="button" class="text-red-600 hover:text-red-800 font-bold remove-specification">X</button>
                        </div>
                    `;
                    container.appendChild(newRow);
                    specificationIndex++;
                });
            }

            const container = document.getElementById('specifications-container');
            if(container) {
                container.addEventListener('click', function (e) {
                    if (e.target && e.target.classList.contains('remove-specification')) {
                        e.target.closest('.specification-row').remove();
                    }
                });
            }
        });
    </script>
    @endpush
</x-app-layout>