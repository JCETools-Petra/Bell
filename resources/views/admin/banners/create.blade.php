<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Banner') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700">Banner Image</label>
                                <input type="file" name="image" id="image" class="mt-1 block w-full" required>
                            </div>
                            <div>
                                <label for="link_url" class="block text-sm font-medium text-gray-700">Link URL (Optional)</label>
                                <input type="url" name="link_url" id="link_url" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="https://example.com">
                            </div>
                            <div>
                                <label for="order" class="block text-sm font-medium text-gray-700">Order (Optional)</label>
                                <input type="number" name="order" id="order" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="0">
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" checked>
                                    <span class="ml-2 text-sm text-gray-600">Active</span>
                                </label>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">Save Banner</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>