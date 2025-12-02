<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Edit Recreation Area: ') . $recreationArea->name }}
            </h2>
            <a href="{{ route('admin.recreation-areas.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.recreation-areas.update', $recreationArea) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                                <input type="text" name="name" id="name" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('name', $recreationArea->name) }}" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="4" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" required>{{ old('description', $recreationArea->description) }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-bold text-gray-700 mb-2">Display Order</label>
                                <input type="number" name="order" id="order" class="w-full md:w-1/3 rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ old('order', $recreationArea->order) }}" min="0">
                                <p class="text-xs text-gray-500 mt-1">Lower numbers appear first.</p>
                                @error('order')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Images</h3>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Upload New Images</label>
                                <div id="images-container">
                                    <div class="image-input-group mb-4 p-4 border border-gray-200 rounded-lg">
                                        <div class="mb-2">
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Image</label>
                                            <input type="file" name="images[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 mb-1">Caption (Optional)</label>
                                            <input type="text" name="captions[]" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="E.g., Olympic size swimming pool">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" onclick="addImageInput()" class="mt-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm">
                                    <i class="fas fa-plus mr-2"></i> Add More Images
                                </button>
                            </div>

                            @if($recreationArea->images->count() > 0)
                                <h4 class="text-md font-bold text-gray-900 mb-3">Existing Images</h4>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($recreationArea->images as $image)
                                        <div class="relative group rounded-xl overflow-hidden shadow-sm border border-gray-100">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="h-32 w-full object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                                <p class="text-white text-xs truncate">{{ $image->caption ?? 'No caption' }}</p>
                                            </div>
                                            <form action="{{ route('admin.recreation-areas.images.destroy', [$recreationArea, $image]) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this image?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-lg hover:bg-red-600">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500 italic">No images uploaded yet.</p>
                            @endif
                        </div>
                        
                        <div class="border-t border-gray-100 pt-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ $recreationArea->is_active ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 text-sm font-bold text-gray-700">Active (visible on frontend)</label>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.recreation-areas.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Update Recreation Area
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function addImageInput() {
            const container = document.getElementById('images-container');
            const newGroup = document.createElement('div');
            newGroup.className = 'image-input-group mb-4 p-4 border border-gray-200 rounded-lg relative';
            newGroup.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
                <div class="mb-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Image</label>
                    <input type="file" name="images[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Caption (Optional)</label>
                    <input type="text" name="captions[]" class="block w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="E.g., Olympic size swimming pool">
                </div>
            `;
            container.appendChild(newGroup);
        }
    </script>
    @endpush
</x-app-layout>
