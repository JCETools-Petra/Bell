<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Homepage Settings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
       <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl shadow-sm">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        <p class="font-bold">Oops! Ada beberapa kesalahan:</p>
                    </div>
                    <ul class="list-disc list-inside ml-8 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        {{-- General Website Settings --}}
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold text-brand-dark border-b border-gray-100 pb-4">General Website Settings</h3>
                            <div>
                                <label for="website_title" class="block text-sm font-bold text-gray-700 mb-2">Website Title</label>
                                <input type="text" name="website_title" id="website_title" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['website_title'] ?? '' }}">
                            </div>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <label class="flex items-center">
                                    <input type="checkbox" name="show_logo_text" value="1" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ ($settings['show_logo_text'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm font-bold text-gray-800">Tampilkan Teks di Samping Logo</span>
                                </label>
                                <p class="text-xs text-gray-500 ml-6 mt-1">Jika dicentang, tulisan "Sora Hotel" akan muncul di samping logo pada navbar.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="logo_path" class="block text-sm font-bold text-gray-700 mb-2">Logo</label>
                                    <input type="file" name="logo_path" id="logo_path" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                                    @if(isset($settings['logo_path']))
                                        <div class="mt-4">
                                            <p class="text-xs text-gray-500 mb-2">Logo Saat Ini:</p>
                                            <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Current Logo" class="h-16 w-auto object-contain border border-gray-200 p-2 rounded-xl bg-gray-50">
                                        </div>
                                    @endif
                                </div>
                                 <div>
                                    <label for="logo_height" class="block text-sm font-bold text-gray-700 mb-2">Ukuran Tinggi Logo (pixel)</label>
                                    <input type="number" name="logo_height" id="logo_height"
                                           class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm"
                                           value="{{ $settings['logo_height'] ?? '40' }}"
                                           placeholder="Contoh: 40">
                                    <p class="text-xs text-gray-500 mt-1">Atur tinggi logo. Lebar akan menyesuaikan otomatis.</p>
                                </div>
                                <div>
                                    <label for="favicon_path" class="block text-sm font-bold text-gray-700 mb-2">Favicon</label>
                                    <input type="file" name="favicon_path" id="favicon_path" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                                    @if(isset($settings['favicon_path']))
                                        <div class="mt-4">
                                            <p class="text-xs text-gray-500 mb-2">Favicon Saat Ini:</p>
                                            <img src="{{ asset('storage/' . $settings['favicon_path']) }}" alt="Current Favicon" class="h-8 w-8 object-contain border border-gray-200 p-1 rounded-lg bg-gray-50">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Featured Content Settings --}}
                        <div class="space-y-6 pt-6 border-t border-gray-100">
                            <h3 class="text-xl font-bold text-brand-dark border-b border-gray-100 pb-4">Featured Content Settings</h3>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Konten Unggulan</label>
                                <p class="text-xs text-gray-500 mb-3">Pilih konten yang akan ditampilkan di halaman depan.</p>
                                <div class="flex flex-wrap gap-6">
                                    @php
                                        $selectedOptions = explode(',', $settings['featured_display_option'] ?? '');
                                    @endphp
                                    <label class="inline-flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" name="featured_display_option[]" value="rooms" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ in_array('rooms', $selectedOptions) ? 'checked' : '' }}>
                                        <span class="ml-2 font-medium text-gray-700">Rooms</span>
                                    </label>
                                    <label class="inline-flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" name="featured_display_option[]" value="mice" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ in_array('mice', $selectedOptions) ? 'checked' : '' }}>
                                        <span class="ml-2 font-medium text-gray-700">MICE</span>
                                    </label>
                                    <label class="inline-flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                        <input type="checkbox" name="featured_display_option[]" value="restaurants" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ in_array('restaurants', $selectedOptions) ? 'checked' : '' }}>
                                        <span class="ml-2 font-medium text-gray-700">Restaurants</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Hero Section Settings --}}
                        <div class="space-y-6 pt-6 border-t border-gray-100">
                            <h3 class="text-xl font-bold text-brand-dark border-b border-gray-100 pb-4">Hero Section Settings</h3>
                            <div>
                                <label for="hero_bg_image" class="block text-sm font-bold text-gray-700 mb-2">Gambar Latar Belakang (Fallback)</label>
                                <p class="text-xs text-gray-500 mb-2">Gambar ini akan digunakan jika tidak ada gambar di "Hero Sliders".</p>
                                <input type="file" name="hero_bg_image" id="hero_bg_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                                @if(isset($settings['hero_bg_image']))
                                    <div class="mt-4">
                                        <p class="text-xs text-gray-500 mb-2">Gambar Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $settings['hero_bg_image']) }}" alt="Current Hero Background" class="h-32 w-auto object-cover rounded-xl border border-gray-200 shadow-sm">
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label for="hero_text_align" class="block text-sm font-bold text-gray-700 mb-2">Penjajaran Teks</label>
                                <select name="hero_text_align" id="hero_text_align" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                                    <option value="text-center" {{ ($settings['hero_text_align'] ?? 'text-center') == 'text-center' ? 'selected' : '' }}>Center</option>
                                    <option value="text-start" {{ ($settings['hero_text_align'] ?? '') == 'text-start' ? 'selected' : '' }}>Left</option>
                                    <option value="text-end" {{ ($settings['hero_text_align'] ?? '') == 'text-end' ? 'selected' : '' }}>Right</option>
                                </select>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="hero_slider_height" class="block text-sm font-bold text-gray-700 mb-2">Hero Slider Height</label>
                                    <input type="text" name="hero_slider_height" id="hero_slider_height" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['hero_slider_height'] ?? '' }}" placeholder="e.g., 100vh or 800px">
                                    <p class="mt-1 text-xs text-gray-500">Contoh: `100vh` (full screen), `800px`. Biarkan kosong for default (auto).</p>
                                </div>
                                <div>
                                    <label for="hero_slider_width" class="block text-sm font-bold text-gray-700 mb-2">Hero Slider Width</label>
                                    <input type="text" name="hero_slider_width" id="hero_slider_width" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['hero_slider_width'] ?? '' }}" placeholder="e.g., 100%">
                                    <p class="mt-1 text-xs text-gray-500">Contoh: `100%`. Biarkan kosong untuk default (100%).</p>
                                </div>
                            </div>

                            <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                                <label for="hero_title" class="block text-sm font-bold text-gray-700 mb-2">Judul Hero</label>
                                <input type="text" name="hero_title" id="hero_title" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['hero_title'] ?? '' }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label for="hero_title_font_size" class="block text-xs font-bold text-gray-600 mb-1">Ukuran Font (rem)</label>
                                        <input type="number" step="0.1" name="hero_title_font_size" id="hero_title_font_size" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['hero_title_font_size'] ?? '4.5' }}">
                                    </div>
                                    <div>
                                        <label for="hero_title_font_family" class="block text-xs font-bold text-gray-600 mb-1">Jenis Font</label>
                                        <select name="hero_title_font_family" id="hero_title_font_family" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                                            <option value="'Playfair Display', serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                            <option value="'Montserrat', sans-serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                            <option value="'Lora', serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                            <option value="'Poppins', sans-serif" {{ ($settings['hero_title_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                                <label for="hero_subtitle" class="block text-sm font-bold text-gray-700 mb-2">Subjudul Hero</label>
                                <input type="text" name="hero_subtitle" id="hero_subtitle" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['hero_subtitle'] ?? '' }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label for="hero_subtitle_font_size" class="block text-xs font-bold text-gray-600 mb-1">Ukuran Font (rem)</label>
                                        <input type="number" step="0.1" name="hero_subtitle_font_size" id="hero_subtitle_font_size" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['hero_subtitle_font_size'] ?? '1.5' }}">
                                    </div>
                                    <div>
                                        <label for="hero_subtitle_font_family" class="block text-xs font-bold text-gray-600 mb-1">Jenis Font</label>
                                        <select name="hero_subtitle_font_family" id="hero_subtitle_font_family" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                                            <option value="'Montserrat', sans-serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                            <option value="'Playfair Display', serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                            <option value="'Lora', serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                            <option value="'Poppins', sans-serif" {{ ($settings['hero_subtitle_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- About Section Settings --}}
                        <div class="space-y-6 pt-6 border-t border-gray-100">
                            <h3 class="text-xl font-bold text-brand-dark border-b border-gray-100 pb-4">About Section Settings</h3>
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <label class="flex items-center">
                                    <input type="checkbox" name="show_about_section" value="1" class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary" {{ ($settings['show_about_section'] ?? '1') == '1' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm font-bold text-gray-800">Tampilkan "About Section" di Halaman Depan</span>
                                </label>
                            </div>
                            <div>
                                <label for="about_text_align" class="block text-sm font-bold text-gray-700 mb-2">Penjajaran Teks</label>
                                <select name="about_text_align" id="about_text_align" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                                    <option value="text-center" {{ ($settings['about_text_align'] ?? 'text-center') == 'text-center' ? 'selected' : '' }}>Center</option>
                                    <option value="text-start" {{ ($settings['about_text_align'] ?? '') == 'text-start' ? 'selected' : '' }}>Left</option>
                                    <option value="text-end" {{ ($settings['about_text_align'] ?? '') == 'text-end' ? 'selected' : '' }}>Right</option>
                                </select>
                            </div>
                            <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                                <label for="about_title" class="block text-sm font-bold text-gray-700 mb-2">Judul About</label>
                                <input type="text" name="about_title" id="about_title" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['about_title'] ?? '' }}">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label for="about_title_font_size" class="block text-xs font-bold text-gray-600 mb-1">Ukuran Font (rem)</label>
                                        <input type="number" step="0.1" name="about_title_font_size" id="about_title_font_size" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['about_title_font_size'] ?? '2.8' }}">
                                    </div>
                                    <div>
                                        <label for="about_title_font_family" class="block text-xs font-bold text-gray-600 mb-1">Jenis Font</label>
                                        <select name="about_title_font_family" id="about_title_font_family" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                                            <option value="'Playfair Display', serif" {{ ($settings['about_title_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                            <option value="'Montserrat', sans-serif" {{ ($settings['about_title_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                            <option value="'Lora', serif" {{ ($settings['about_title_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                            <option value="'Poppins', sans-serif" {{ ($settings['about_title_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 border border-gray-100 rounded-2xl bg-gray-50">
                                <label for="about_content" class="block text-sm font-bold text-gray-700 mb-2">Konten About</label>
                                <textarea name="about_content" id="about_content" rows="5" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ $settings['about_content'] ?? '' }}</textarea>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label for="about_content_font_size" class="block text-xs font-bold text-gray-600 mb-1">Ukuran Font (rem)</label>
                                        <input type="number" step="0.1" name="about_content_font_size" id="about_content_font_size" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['about_content_font_size'] ?? '1' }}">
                                    </div>
                                    <div>
                                        <label for="about_content_font_family" class="block text-xs font-bold text-gray-600 mb-1">Jenis Font</label>
                                        <select name="about_content_font_family" id="about_content_font_family" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">
                                            <option value="'Montserrat', sans-serif" {{ ($settings['about_content_font_family'] ?? '') == "'Montserrat', sans-serif" ? 'selected' : '' }}>Montserrat (Modern)</option>
                                            <option value="'Playfair Display', serif" {{ ($settings['about_content_font_family'] ?? '') == "'Playfair Display', serif" ? 'selected' : '' }}>Playfair Display (Elegan)</option>
                                            <option value="'Lora', serif" {{ ($settings['about_content_font_family'] ?? '') == "'Lora', serif" ? 'selected' : '' }}>Lora (Klasik)</option>
                                            <option value="'Poppins', sans-serif" {{ ($settings['about_content_font_family'] ?? '') == "'Poppins', sans-serif" ? 'selected' : '' }}>Poppins (Santai)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- MICE Layout Icons --}}
                        <div class="space-y-6 pt-6 border-t border-gray-100">
                            <h3 class="text-xl font-bold text-brand-dark border-b border-gray-100 pb-4">MICE Layout Icons</h3>
                            <p class="text-sm text-gray-600">Unggah gambar/ikon yang akan ditampilkan di halaman detail MICE. Direkomendasikan gambar kotak (rasio 1:1) dengan latar belakang transparan atau putih.</p>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
                                @php
                                    $layouts = ['classroom', 'theatre', 'ushape', 'round', 'board'];
                                @endphp
                                @foreach($layouts as $layout)
                                    @php $key = 'layout_icon_' . $layout; @endphp
                                    <div class="p-4 border border-gray-100 rounded-2xl bg-gray-50 space-y-3 hover:shadow-md transition-shadow">
                                        <label for="{{ $key }}" class="block text-sm font-bold text-gray-700 capitalize text-center">{{ str_replace('_', ' ', $layout) }}</label>
                                        <div class="flex justify-center">
                                            @if(isset($settings[$key]))
                                                <img src="{{ asset('storage/' . $settings[$key]) }}" alt="{{ $layout }} icon" class="h-24 w-24 object-contain border border-gray-200 p-2 rounded-xl bg-white">
                                            @else
                                                <div class="h-24 w-24 flex items-center justify-center bg-gray-100 rounded-xl border border-dashed border-gray-300 text-gray-400">
                                                    <i class="fas fa-image text-2xl"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" name="{{ $key }}" id="{{ $key }}" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
