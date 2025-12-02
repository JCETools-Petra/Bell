<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Edit Hero Slide') }}
            </h2>
            <a href="{{ route('admin.hero-sliders.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.hero-sliders.update', $slider) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        {{-- Image --}}
                        <div>
                            <label for="image_path" class="block text-sm font-bold text-gray-700 mb-2">Image (Leave blank to keep current)</label>
                            <input type="file" name="image_path" id="image_path" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                            <div class="mt-4">
                                <p class="text-xs text-gray-500 mb-2">Current Image:</p>
                                <img src="{{ asset('storage/' . $slider->image_path) }}" alt="Current Image" class="h-32 w-auto rounded-xl border border-gray-200 shadow-sm">
                            </div>
                            @error('image_path')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Order --}}
                        <div>
                            <label for="order" class="block text-sm font-bold text-gray-700 mb-2">Order</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $slider->order) }}" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                            @error('order')
                                <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Active --}}
                        <div class="border-t border-gray-100 pt-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ $slider->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary">
                                <label for="is_active" class="ml-2 text-sm font-bold text-gray-700">{{ __('Active') }}</label>
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.hero-sliders.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
