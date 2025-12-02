<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Edit MICE Room: ') . $miceRoom->name }}
            </h2>
            <a href="{{ route('admin.mice.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <i class="fas fa-exclamation-circle text-xl"></i>
                                <p class="font-bold">Oops! There were some problems with your input.</p>
                            </div>
                            <ul class="list-disc list-inside ml-8 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.mice.update', $miceRoom->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">MICE Room Name</label>
                                <input type="text" name="name" id="name" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('name', $miceRoom->name) }}" required>
                            </div>

                            <div class="md:col-span-2">
                                <label for="slug" class="block text-sm font-bold text-gray-700 mb-2">Slug (URL)</label>
                                <input type="text" name="slug" id="slug" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm bg-gray-50" value="{{ old('slug', $miceRoom->slug) }}" required>
                                <p class="text-xs text-gray-500 mt-1">Auto-generated from name. Must be unique.</p>
                            </div>
                            <div>
                                <label for="dimension" class="block text-sm font-bold text-gray-700 mb-2">Dimension (e.g., 15 x 16)</label>
                                <input type="text" name="dimension" id="dimension" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('dimension', $miceRoom->dimension) }}">
                            </div>
                            <div>
                                <label for="size_sqm" class="block text-sm font-bold text-gray-700 mb-2">Size in SQM² (e.g., 240 M²)</label>
                                <input type="text" name="size_sqm" id="size_sqm" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('size_sqm', $miceRoom->size_sqm) }}">
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Layout Specifications</h3>
                            <div id="specifications-container" class="space-y-4">
                                 @if ($miceRoom->specifications && is_string($miceRoom->specifications))
                                    @foreach (json_decode($miceRoom->specifications, true) as $index => $spec)
                                    <div class="grid grid-cols-1 md:grid-cols-10 gap-4 specification-row items-center bg-gray-50 p-4 rounded-xl border border-gray-100">
                                        <div class="md:col-span-3">
                                            <label class="text-sm font-bold text-gray-700 mb-1 block">Layout Name</label>
                                            <input type="text" name="specifications[{{ $index }}][key]" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" placeholder="e.g., Classroom" value="{{ $spec['key'] ?? '' }}">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="text-sm font-bold text-gray-700 mb-1 block">Capacity (Pax)</label>
                                            <input type="text" name="specifications[{{ $index }}][value]" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" placeholder="e.g., 150 Pax" value="{{ $spec['value'] ?? '' }}">
                                        </div>
                                        <div class="md:col-span-4">
                                            <label class="text-sm font-bold text-gray-700 mb-1 block">Layout Image</label>
                                            <input type="file" name="specifications[{{ $index }}][image]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                                            <input type="hidden" name="specifications[{{ $index }}][image_path]" value="{{ $spec['image'] ?? '' }}">
                                            @if(!empty($spec['image']))
                                                <img src="{{ asset($spec['image']) }}" alt="{{ $spec['key'] ?? '' }}" width="50" class="mt-2 rounded-lg border border-gray-200">
                                            @endif
                                        </div>
                                        <div class="md:col-span-1 pt-6 text-right">
                                            <button type="button" class="px-3 py-2 text-sm font-bold text-white bg-red-500 rounded-lg hover:bg-red-600 shadow-sm remove-specification transition-all">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                            <button type="button" id="add-specification" class="mt-4 px-4 py-2 bg-gray-800 text-white font-bold rounded-xl hover:bg-gray-900 transition-all shadow-lg shadow-gray-800/20">
                                <i class="fas fa-plus mr-2"></i> Add Layout
                            </button>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="rate_details" class="block text-sm font-bold text-gray-700 mb-2">Rate Details</label>
                                    <textarea name="rate_details" id="rate_details" rows="4" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ old('rate_details', $miceRoom->rate_details) }}</textarea>
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="description" rows="4" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ old('description', $miceRoom->description) }}</textarea>
                                </div>
                                <div>
                                    <label for="facilities" class="block text-sm font-bold text-gray-700 mb-2">Facilities (one per line)</label>
                                    <textarea name="facilities" id="facilities" rows="4" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ old('facilities', $miceRoom->facilities) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Images</h3>
                            
                            <div class="mb-6">
                                <label for="images" class="block text-sm font-bold text-gray-700 mb-2">Upload New Images</label>
                                <input type="file" name="images[]" id="images" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all" multiple>
                            </div>

                            @if($miceRoom->images->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($miceRoom->images as $image)
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
                                <input type="checkbox" name="is_available" id="is_available" value="1" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ $miceRoom->is_available ? 'checked' : '' }}>
                                <label for="is_available" class="ml-2 text-sm font-bold text-gray-700">Available for booking</label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.mice.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Update MICE Room
                            </button>
                        </div>
                    </form>
                    
                    {{-- Hidden Delete Forms --}}
                    @foreach($miceRoom->images as $image)
                        <form id="delete-image-{{ $image->id }}" action="{{ route('admin.images.destroy', $image->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-generate slug
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            
            nameInput.addEventListener('input', function() {
                let slug = this.value.toLowerCase()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
                slugInput.value = slug;
            });

            let specificationIndex = {{ $miceRoom->specifications ? count(json_decode($miceRoom->specifications, true)) : 0 }};

            document.getElementById('add-specification').addEventListener('click', function () {
                const container = document.getElementById('specifications-container');
                const newRow = document.createElement('div');
                newRow.className = 'grid grid-cols-1 md:grid-cols-10 gap-4 specification-row items-center bg-gray-50 p-4 rounded-xl border border-gray-100';
                newRow.innerHTML = `
                    <div class="md:col-span-3">
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Layout Name</label>
                        <input type="text" name="specifications[${specificationIndex}][key]" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" placeholder="e.g., Classroom">
                    </div>
                    <div class="md:col-span-2">
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Capacity (Pax)</label>
                        <input type="text" name="specifications[${specificationIndex}][value]" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" placeholder="e.g., 150 Pax">
                    </div>
                    <div class="md:col-span-4">
                        <label class="text-sm font-bold text-gray-700 mb-1 block">Layout Image</label>
                        <input type="file" name="specifications[${specificationIndex}][image]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                    </div>
                    <div class="md:col-span-1 pt-6 text-right">
                        <button type="button" class="px-3 py-2 text-sm font-bold text-white bg-red-500 rounded-lg hover:bg-red-600 shadow-sm remove-specification transition-all">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                `;
                container.appendChild(newRow);
                specificationIndex++;
            });

            container.addEventListener('click', function (e) {
                if (e.target && e.target.closest('.remove-specification')) {
                    e.target.closest('.specification-row').remove();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
