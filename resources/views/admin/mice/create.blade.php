<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New MICE Room') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.mice.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">MICE Room Name</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('name') }}" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label for="dimension" class="block text-sm font-medium text-gray-700">Dimension (e.g., 15 x 16)</label>
                                <input type="text" name="dimension" id="dimension" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('dimension') }}">
                            </div>
                            <div>
                                <label for="size_sqm" class="block text-sm font-medium text-gray-700">Size in SQM² (e.g., 240 M²)</label>
                                <input type="text" name="size_sqm" id="size_sqm" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('size_sqm') }}">
                            </div>
                        </div>

                        <hr class="my-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Layout Capacities (Pax)</h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-4">
                            <div>
                                <label for="capacity_classroom" class="block text-sm font-medium text-gray-700">Classroom</label>
                                <input type="number" name="capacity_classroom" id="capacity_classroom" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('capacity_classroom') }}">
                            </div>
                            <div>
                                <label for="capacity_theatre" class="block text-sm font-medium text-gray-700">Theatre</label>
                                <input type="number" name="capacity_theatre" id="capacity_theatre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('capacity_theatre') }}">
                            </div>
                             <div>
                                <label for="capacity_ushape" class="block text-sm font-medium text-gray-700">U-Shape</label>
                                <input type="number" name="capacity_ushape" id="capacity_ushape" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('capacity_ushape') }}">
                            </div>
                             <div>
                                <label for="capacity_round" class="block text-sm font-medium text-gray-700">Round Table</label>
                                <input type="number" name="capacity_round" id="capacity_round" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('capacity_round') }}">
                            </div>
                             <div>
                                <label for="capacity_board" class="block text-sm font-medium text-gray-700">Board Room</label>
                                <input type="number" name="capacity_board" id="capacity_board" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('capacity_board') }}">
                            </div>
                        </div>

                        <hr class="my-6">
                        <div class="mb-4">
                            <label for="rate_details" class="block text-sm font-medium text-gray-700">Rate Details</label>
                            <textarea name="rate_details" id="rate_details" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('rate_details') }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('description') }}</textarea>
                        </div>
                         <div class="mb-4">
                            <label for="facilities" class="block text-sm font-medium text-gray-700">Facilities (one per line)</label>
                            <textarea name="facilities" id="facilities" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>{{ old('facilities') }}</textarea>
                        </div>

                        <hr class="my-6">
                        <div class="mb-4">
                            <label for="images" class="block text-sm font-medium text-gray-700">Upload Images</label>
                            <input type="file" name="images[]" id="images" class="mt-1 block w-full" multiple>
                        </div>
                        
                        <hr class="my-6">
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_available" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" checked>
                                <span class="ml-2 text-sm text-gray-600">Available for booking</span>
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="px-4 py-2 bg-brand-red text-white rounded-md hover:opacity-90 transition-opacity">Save MICE Room</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>