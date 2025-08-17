<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Homepage Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Featured Content Settings</h3>
                        <div class="mb-4">
                            <label for="featured_display_option" class="block text-sm font-medium text-gray-700">Show on Homepage</label>
                            <select name="featured_display_option" id="featured_display_option" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="rooms" {{ ($settings['featured_display_option'] ?? 'rooms') == 'rooms' ? 'selected' : '' }}>Rooms Only</option>
                                <option value="mice" {{ ($settings['featured_display_option'] ?? '') == 'mice' ? 'selected' : '' }}>MICE Only</option>
                                <option value="both" {{ ($settings['featured_display_option'] ?? '') == 'both' ? 'selected' : '' }}>Both Rooms and MICE</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Pilih konten apa yang ingin ditonjolkan di halaman depan.</p>
                        </div>
                        <hr class="my-6">

                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Hero Section</h3>
                        <div class="mb-4">
                            <label for="hero_bg_image" class="block text-sm font-medium text-gray-700">Hero Background Image</label>
                            <input type="file" name="hero_bg_image" id="hero_bg_image" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                            @if(isset($settings['hero_bg_image']))
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">Current Image:</p>
                                    <img src="{{ asset('storage/' . $settings['hero_bg_image']) }}" alt="Current Hero Background" class="mt-2 rounded-md h-32 w-auto object-cover">
                                </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="hero_text_align" class="block text-sm font-medium text-gray-700">Text Alignment</label>
                            <select name="hero_text_align" id="hero_text_align" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="text-center" {{ ($settings['hero_text_align'] ?? 'text-center') == 'text-center' ? 'selected' : '' }}>Center</option>
                                <option value="text-start" {{ ($settings['hero_text_align'] ?? '') == 'text-start' ? 'selected' : '' }}>Left</option>
                                <option value="text-end" {{ ($settings['hero_text_align'] ?? '') == 'text-end' ? 'selected' : '' }}>Right</option>
                            </select>
                        </div>
                        <div class="mb-4 p-4 border rounded-md">
                            <label for="hero_title" class="block text-sm font-medium text-gray-700 font-bold">Hero Title</label>
                            <input type="text" name="hero_title" id="hero_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $settings['hero_title'] ?? '' }}">
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label for="hero_title_font_size" class="block text-xs font-medium text-gray-600">Font Size (rem)</label>
                                    <input type="number" step="0.1" name="hero_title_font_size" id="hero_title_font_size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $settings['hero_title_font_size'] ?? '4.5' }}">
                                </div>
                                <div>
                                    <label for="hero_title_font_family" class="block text-xs font-medium text-gray-600">Font Family</label>
                                    <select name="hero_title_font_family" id="hero_title_font_family" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="'Playfair Display', serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                        <option value="'Montserrat', sans-serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                        <option value="'Lora', serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                        <option value="'Poppins', sans-serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 p-4 border rounded-md">
                            <label for="hero_subtitle" class="block text-sm font-medium text-gray-700 font-bold">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" id="hero_subtitle" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $settings['hero_subtitle'] ?? '' }}">
                             <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label for="hero_subtitle_font_size" class="block text-xs font-medium text-gray-600">Font Size (rem)</label>
                                    <input type="number" step="0.1" name="hero_subtitle_font_size" id="hero_subtitle_font_size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $settings['hero_subtitle_font_size'] ?? '1.5' }}">
                                </div>
                                <div>
                                    <label for="hero_subtitle_font_family" class="block text-xs font-medium text-gray-600">Font Family</label>
                                    <select name="hero_subtitle_font_family" id="hero_subtitle_font_family" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="'Montserrat', sans-serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                        <option value="'Playfair Display', serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                        <option value="'Lora', serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                        <option value="'Poppins', sans-serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr class="my-6">

                        <h3 class="text-lg font-bold mb-4 border-b pb-2">About Section</h3>
                        <div class="mb-4 bg-gray-50 p-3 rounded-md">
                            <label class="flex items-center">
                                <input type="checkbox" name="show_about_section" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm" {{ ($settings['show_about_section'] ?? '1') == '1' ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-800 font-semibold">Show "About Section" on Homepage</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label for="about_text_align" class="block text-sm font-medium text-gray-700">Text Alignment</label>
                            <select name="about_text_align" id="about_text_align" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option value="text-center" {{ ($settings['about_text_align'] ?? 'text-center') == 'text-center' ? 'selected' : '' }}>Center</option>
                                <option value="text-start" {{ ($settings['about_text_align'] ?? '') == 'text-start' ? 'selected' : '' }}>Left</option>
                                <option value="text-end" {{ ($settings['about_text_align'] ?? '') == 'text-end' ? 'selected' : '' }}>Right</option>
                            </select>
                        </div>
                        <div class="mb-4 p-4 border rounded-md">
                            <label for="about_title" class="block text-sm font-medium text-gray-700 font-bold">About Title</label>
                            <input type="text" name="about_title" id="about_title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $settings['about_title'] ?? '' }}">
                             <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label for="about_title_font_size" class="block text-xs font-medium text-gray-600">Font Size (rem)</label>
                                    <input type="number" step="0.1" name="about_title_font_size" id="about_title_font_size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $settings['about_title_font_size'] ?? '2.8' }}">
                                </div>
                                <div>
                                    <label for="about_title_font_family" class="block text-xs font-medium text-gray-600">Font Family</label>
                                    <select name="about_title_font_family" id="about_title_font_family" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="'Playfair Display', serif" {{ ($settings['about_title_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                        <option value="'Montserrat', sans-serif" {{ ($settings['about_title_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                        <option value="'Lora', serif" {{ ($settings['about_title_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                        <option value="'Poppins', sans-serif" {{ ($settings['about_title_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 p-4 border rounded-md">
                           <label for="about_content" class="block text-sm font-medium text-gray-700 font-bold">About Content</label>
                           <textarea name="about_content" id="about_content" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $settings['about_content'] ?? '' }}</textarea>
                           <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <label for="about_content_font_size" class="block text-xs font-medium text-gray-600">Font Size (rem)</label>
                                    <input type="number" step="0.1" name="about_content_font_size" id="about_content_font_size" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ $settings['about_content_font_size'] ?? '1' }}">
                                </div>
                                <div>
                                    <label for="about_content_font_family" class="block text-xs font-medium text-gray-600">Font Family</label>
                                    <select name="about_content_font_family" id="about_content_font_family" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                        <option value="'Montserrat', sans-serif" {{ ($settings['about_content_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                        <option value="'Playfair Display', serif" {{ ($settings['about_content_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                        <option value="'Lora', serif" {{ ($settings['about_content_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                        <option value="'Poppins', sans-serif" {{ ($settings['about_content_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="my-6">

                        <h3 class="text-lg font-bold mb-4 border-b pb-2">MICE Layout Icons</h3>
                        <p class="text-sm text-gray-600 mb-4">Upload gambar/ikon yang akan ditampilkan di halaman detail MICE. Direkomendasikan gambar kotak (rasio 1:1) dengan latar belakang transparan atau putih.</p>
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-4">
                            @php
                                $layouts = ['classroom', 'theatre', 'ushape', 'round', 'board'];
                            @endphp
                            @foreach($layouts as $layout)
                                @php $key = 'layout_icon_' . $layout; @endphp
                                <div class="p-4 border rounded-md">
                                    <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 font-bold capitalize">{{ str_replace('_', ' ', $layout) }}</label>
                                    <input type="file" name="{{ $key }}" id="{{ $key }}" class="mt-1 block w-full text-sm">
                                    @if(isset($settings[$key]))
                                        <img src="{{ asset('storage/' . $settings[$key]) }}" alt="{{ $layout }} icon" class="mt-2 rounded-md h-24 w-24 object-contain border p-1">
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <button type="submit" class="px-4 py-2 bg-brand-red text-white rounded-md hover:opacity-90 transition-opacity">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>