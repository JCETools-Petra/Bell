<x-app-layout>
    {{-- Slot untuk header halaman --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Website Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- General Settings --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-3 mb-4">General Settings</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="website_title" class="block font-medium text-sm text-gray-700">Website Title</label>
                            <input type="text" name="website_title" id="website_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('website_title', $settings['website_title'] ?? '') }}" required>
                        </div>
                        <div>
                            <label for="logo_height" class="block font-medium text-sm text-gray-700">Logo Height (px)</label>
                            <input type="number" name="logo_height" id="logo_height" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('logo_height', $settings['logo_height'] ?? '40') }}" required>
                        </div>
                        <div>
                            <label for="logo" class="block font-medium text-sm text-gray-700">Upload Logo</label>
                            <input type="file" name="logo" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if(isset($settings['logo_path']))
                                <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Current Logo" class="mt-2 h-12 border rounded">
                            @endif
                        </div>
                        <div>
                            <label for="favicon" class="block font-medium text-sm text-gray-700">Upload Favicon</label>
                            <input type="file" name="favicon" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if(isset($settings['favicon_path']))
                                <img src="{{ asset('storage/' . $settings['favicon_path']) }}" alt="Current Favicon" class="mt-2 h-8 border rounded">
                            @endif
                        </div>
                        <div class="md:col-span-2">
                            <label for="show_logo_text" class="flex items-center">
                                <input type="checkbox" name="show_logo_text" id="show_logo_text" value="1" {{ ($settings['show_logo_text'] ?? '1') == '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Show Website Title next to Logo</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Hero Section Settings --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-3 mb-4">Homepage Hero Section</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="hero_title" class="block font-medium text-sm text-gray-700">Hero Title</label>
                            <input type="text" name="hero_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('hero_title', $settings['hero_title'] ?? '') }}">
                        </div>
                        <div>
                            <label for="hero_subtitle" class="block font-medium text-sm text-gray-700">Hero Subtitle</label>
                            <textarea name="hero_subtitle" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                        </div>
                        <div>
                            <label for="hero_image" class="block font-medium text-sm text-gray-700">Hero Background Image</label>
                            <input type="file" name="hero_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if(isset($settings['hero_image_path']))
                                <img src="{{ asset('storage/' . $settings['hero_image_path']) }}" alt="Current Hero Image" class="mt-2 w-48 border rounded">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Contact & Social Media Settings --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-3 mb-4">Contact & Social Media</h3>
                    <div class="space-y-4">
                        <div>
                            <label for="contact_address" class="block font-medium text-sm text-gray-700">Address</label>
                            <input type="text" name="contact_address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_address', $settings['contact_address'] ?? '') }}">
                        </div>
                        <div>
                            <label for="contact_maps_embed" class="block font-medium text-sm text-gray-700">Google Maps Embed Code</label>
                            <textarea name="contact_maps_embed" id="contact_maps_embed" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ old('contact_maps_embed', $settings['contact_maps_embed'] ?? '') }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">Buka Google Maps, cari lokasi Anda, klik "Share", lalu "Embed a map", dan salin kode HTML-nya ke sini.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact_phone" class="block font-medium text-sm text-gray-700">Phone Number</label>
                                <input type="text" name="contact_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_phone', $settings['contact_phone'] ?? '') }}">
                            </div>
                            <div>
                                <label for="contact_email" class="block font-medium text-sm text-gray-700">Email Address</label>
                                <input type="email" name="contact_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_email', $settings['contact_email'] ?? '') }}">
                            </div>
                        </div>
                        <hr>
                        <h4 class="text-md font-medium text-gray-800">Social Media Links</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                             <div>
                                <label for="contact_facebook" class="block font-medium text-sm text-gray-700">Facebook URL</label>
                                <input type="url" name="contact_facebook" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_facebook', $settings['contact_facebook'] ?? '') }}">
                            </div>
                             <div>
                                <label for="contact_instagram" class="block font-medium text-sm text-gray-700">Instagram URL</label>
                                <input type="url" name="contact_instagram" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_instagram', $settings['contact_instagram'] ?? '') }}">
                            </div>
                             <div>
                                <label for="contact_linkedin" class="block font-medium text-sm text-gray-700">LinkedIn URL</label>
                                <input type="url" name="contact_linkedin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_linkedin', $settings['contact_linkedin'] ?? '') }}">
                            </div>
                             <div>
                                <label for="contact_youtube" class="block font-medium text-sm text-gray-700">YouTube URL</label>
                                <input type="url" name="contact_youtube" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_youtube', $settings['contact_youtube'] ?? '') }}">
                            </div>
                             <div>
                                <label for="contact_tiktok" class="block font-medium text-sm text-gray-700">TikTok URL</label>
                                <input type="url" name="contact_tiktok" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('contact_tiktok', $settings['contact_tiktok'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Terms and Conditions Section --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                     <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-3 mb-4">Terms and Conditions Page</h3>
                     <div>
                        <label for="terms_and_conditions_editor" class="block font-medium text-sm text-gray-700 mb-1">Page Content</label>
                        <textarea name="terms_and_conditions" id="terms_and_conditions_editor" class="form-control" rows="15">{{ old('terms_and_conditions', $settings['terms_and_conditions'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        tinymce.init({
            selector: '#terms_and_conditions_editor',
            plugins: 'code table lists link image media wordcount',
            toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table | link image media',
            height: 500,
            menubar: false,
        });
    });
</script>
@endpush