<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Recreation Area') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.recreation-areas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="order" class="block text-sm font-medium text-gray-700">Display Order</label>
                            <input type="number" name="order" id="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('order', 0) }}" min="0">
                            <p class="text-xs text-gray-500 mt-1">Lower numbers appear first.</p>
                            @error('order')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Images (with captions)</label>
                            <div id="images-container">
                                <div class="image-input-group mb-4 p-4 border border-gray-200 rounded-lg">
                                    <div class="mb-2">
                                        <label class="block text-xs font-medium text-gray-600 mb-1">Image</label>
                                        <input type="file" name="images[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
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

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" checked>
                                <span class="ml-2 text-sm text-gray-600">Active (visible on frontend)</span>
                            </label>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-admin-secondary">Save Recreation Area</button>
                            <a href="{{ route('admin.recreation-areas.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">Cancel</a>
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
                    <input type="file" name="images[]" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
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
