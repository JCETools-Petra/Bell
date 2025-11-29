<x-app-layout>
    {{-- Slot untuk header halaman --}}
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">
                    {{ __('Website Settings') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola pengaturan website dan integrasi</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                {{-- Method spoofing for POST request --}}

                @if(session('success'))
                    <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-green-700 font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-lg shadow-sm">
                        <div class="flex">
                            <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <ul class="list-disc list-inside text-red-700">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @php
                    // Normalisasi nilai default dari $settings + dukung old()
                    $websiteTitle = old('website_title', $settings['website_title'] ?? '');
                    $logoHeight   = old('logo_height', $settings['logo_height'] ?? '40');
                    $showLogoText = old('show_logo_text', $settings['show_logo_text'] ?? '1');

                    $heroTitle    = old('hero_title', $settings['hero_title'] ?? '');
                    $heroSubtitle = old('hero_subtitle', $settings['hero_subtitle'] ?? '');

                    $addr         = old('contact_address', $settings['contact_address'] ?? '');
                    $mapsEmbed    = old('contact_maps_embed', $settings['contact_maps_embed'] ?? '');
                    $phone        = old('contact_phone', $settings['contact_phone'] ?? '');
                    $email        = old('contact_email', $settings['contact_email'] ?? '');
                    $fb           = old('contact_facebook', $settings['contact_facebook'] ?? '');
                    $ig           = old('contact_instagram', $settings['contact_instagram'] ?? '');
                    $li           = old('contact_linkedin', $settings['contact_linkedin'] ?? '');
                    $yt           = old('contact_youtube', $settings['contact_youtube'] ?? '');
                    $tt           = old('contact_tiktok', $settings['contact_tiktok'] ?? '');

                    $midMerchant  = old('midtrans_merchant_id', $settings['midtrans_merchant_id'] ?? '');
                    $midClientKey = old('midtrans_client_key', $settings['midtrans_client_key'] ?? '');
                    $midServerKey = old('midtrans_server_key', $settings['midtrans_server_key'] ?? '');
                    $midIsProd    = old('midtrans_is_production', $settings['midtrans_is_production'] ?? '0');

                    $waCustMsg    = old('whatsapp_customer_message', $settings['whatsapp_customer_message'] ?? 'Terima kasih! Pembayaran untuk booking ID: {booking_id} telah kami terima. Kamar Anda telah berhasil dipesan. Kami tunggu kedatangan Anda di Bell Hotel Merauke.');
                    $waAdminMsg   = old('whatsapp_admin_message', $settings['whatsapp_admin_message'] ?? "✅ *Konfirmasi Pembayaran Baru!*\n\n*Booking ID:* {booking_id}\n*Nama Tamu:* {guest_name}\n*Telepon:* {guest_phone}\n*Email:* {guest_email}\n*Check-in:* {checkin_date}\n*Check-out:* {checkout_date}");

                    $currentMethod = old('booking_method', $settings['booking_method'] ?? 'direct');

                    // Variabel untuk Running Text
                    $runningTextEnabled = old('running_text_enabled', $settings['running_text_enabled'] ?? '0');
                    $runningTextContent = old('running_text_content', $settings['running_text_content'] ?? '');
                    $runningTextUrl     = old('running_text_url', $settings['running_text_url'] ?? '');
                @endphp
                
                {{-- General Settings --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">General Settings</h3>
                                <p class="text-xs text-gray-500">Logo, title, dan pengaturan umum website</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="website_title" class="block font-medium text-sm text-gray-700">Website Title</label>
                            <input type="text" name="website_title" id="website_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $websiteTitle }}" required>
                        </div>
                        <div>
                            <label for="logo_height" class="block font-medium text-sm text-gray-700">Logo Height (px)</label>
                            <input type="number" name="logo_height" id="logo_height" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $logoHeight }}" required>
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
                            <input type="hidden" name="show_logo_text" value="0">
                            <label for="show_logo_text" class="flex items-center">
                                <input type="checkbox" name="show_logo_text" id="show_logo_text" value="1" {{ (string)$showLogoText === '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Show Website Title next to Logo</span>
                            </label>
                        </div>
                    </div>
                </div>
                </div>

                {{-- Running Text Announcement --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Running Text Announcement</h3>
                                <p class="text-xs text-gray-500">Pengumuman berjalan di bagian atas website</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="mb-4">
                        <input type="hidden" name="running_text_enabled" value="0">
                        <label for="running_text_enabled" class="flex items-center">
                            <input type="checkbox" name="running_text_enabled" id="running_text_enabled" value="1" {{ (string)$runningTextEnabled === '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                            <span class="ml-2 text-sm text-gray-600">Aktifkan Running Text</span>
                        </label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="running_text_content" class="block font-medium text-sm text-gray-700">Teks yang Ditampilkan</label>
                            <input type="text" name="running_text_content" id="running_text_content" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $runningTextContent }}">
                        </div>
                        <div>
                            <label for="running_text_url" class="block font-medium text-sm text-gray-700">Link URL (jika diklik)</label>
                            <input type="url" name="running_text_url" id="running_text_url" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $runningTextUrl }}" placeholder="https://contoh.com/promo">
                        </div>
                    </div>
                </div>
                </div>

                {{-- MICE Layout Icons --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">MICE Layout Icons</h3>
                                <p class="text-xs text-gray-500">Icon untuk setiap layout ruang MICE</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <p class="text-sm text-gray-600 mb-6">Upload an icon for each MICE room layout. These icons will be displayed on all MICE detail pages.</p>
                    
                    @php
                        $layout_icons = [
                            'layout_icon_classroom' => 'Classroom Layout Icon',
                            'layout_icon_theatre'   => 'Theatre Layout Icon',
                            'layout_icon_ushape'    => 'U-Shape Layout Icon',
                            'layout_icon_round'     => 'Round Table Layout Icon',
                            'layout_icon_board'     => 'Board Room Layout Icon',
                        ];
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($layout_icons as $key => $label)
                        <div class="border p-4 rounded-md">
                            <label for="{{ $key }}" class="block text-sm font-medium text-gray-700">{{ $label }}</label>
                            <input type="file" name="{{ $key }}" id="{{ $key }}" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100"/>
                            
                            @if(isset($settings[$key]) && $settings[$key])
                            <div class="mt-4">
                                <p class="text-xs text-gray-500 mb-1">Current Icon:</p>
                                <img src="{{ asset('storage/' . $settings[$key]) }}" class="rounded-md h-20 w-20 object-contain border p-1">
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                </div>

                {{-- Metode Booking --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Metode Booking</h3>
                                <p class="text-xs text-gray-500">Pilih metode reservasi untuk customer</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="booking_method" class="block font-medium text-sm text-gray-700">Metode Booking Aktif</label>
                            <select name="booking_method" id="booking_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="direct" {{ $currentMethod === 'direct' ? 'selected' : '' }}>
                                    Direct Booking (Pembayaran via Midtrans)
                                </option>
                                <option value="manual" {{ $currentMethod === 'manual' ? 'selected' : '' }}>
                                    Manual Booking (Follow-up via WhatsApp)
                                </option>
                            </select>
                            <p class="mt-2 text-xs text-gray-500">Pilih metode yang akan digunakan oleh pelanggan di halaman depan.</p>
                            <div class="mt-2 text-xs">
                                @if($currentMethod === 'manual')
                                    <span class="px-2 py-1 rounded bg-yellow-50 text-yellow-700 border border-yellow-200">Saat ini: Manual — form booking akan mengirim notifikasi WhatsApp ke admin (tanpa halaman pembayaran).</span>
                                @else
                                    <span class="px-2 py-1 rounded bg-blue-50 text-blue-700 border border-blue-200">Saat ini: Direct — pelanggan akan diarahkan ke pembayaran Midtrans.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                {{-- Homepage Hero Section --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Homepage Hero Section</h3>
                                <p class="text-xs text-gray-500">Banner utama halaman depan website</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="hero_title" class="block font-medium text-sm text-gray-700">Hero Title</label>
                            <input type="text" name="hero_title" id="hero_title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $heroTitle }}">
                        </div>
                        <div>
                            <label for="hero_subtitle" class="block font-medium text-sm text-gray-700">Hero Subtitle</label>
                            <textarea name="hero_subtitle" id="hero_subtitle" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ $heroSubtitle }}</textarea>
                        </div>
                        <div>
                            <label for="hero_image" class="block font-medium text-sm text-gray-700">Hero Background Image</label>
                            <input type="file" name="hero_image" id="hero_image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @if(isset($settings['hero_image_path']))
                                <img src="{{ asset('storage/' . $settings['hero_image_path']) }}" alt="Current Hero Image" class="mt-2 w-48 border rounded">
                            @endif
                        </div>
                    </div>
                </div>
                </div>

                {{-- Contact & Social Media --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Contact & Social Media</h3>
                                <p class="text-xs text-gray-500">Informasi kontak dan media sosial hotel</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label for="contact_address" class="block font-medium text-sm text-gray-700">Address</label>
                            <input type="text" name="contact_address" id="contact_address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $addr }}">
                        </div>
                        <div>
                            <label for="contact_maps_embed" class="block font-medium text-sm text-gray-700">Google Maps Embed Code</label>
                            <textarea name="contact_maps_embed" id="contact_maps_embed" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4">{{ $mapsEmbed }}</textarea>
                            <p class="mt-2 text-xs text-gray-500">Buka Google Maps, cari lokasi Anda, klik "Share", lalu "Embed a map", dan salin kode HTML-nya ke sini.</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact_phone" class="block font-medium text-sm text-gray-700">Phone Number</label>
                                <input type="text" name="contact_phone" id="contact_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $phone }}">
                            </div>
                            <div>
                                <label for="contact_email" class="block font-medium text-sm text-gray-700">Email Address</label>
                                <input type="email" name="contact_email" id="contact_email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $email }}">
                            </div>
                        </div>
                        <hr>
                        <h4 class="text-md font-medium text-gray-800">Social Media Links</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="contact_facebook" class="block font-medium text-sm text-gray-700">Facebook URL</label>
                                <input type="url" name="contact_facebook" id="contact_facebook" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $fb }}">
                            </div>
                            <div>
                                <label for="contact_instagram" class="block font-medium text-sm text-gray-700">Instagram URL</label>
                                <input type="url" name="contact_instagram" id="contact_instagram" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $ig }}">
                            </div>
                            <div>
                                <label for="contact_linkedin" class="block font-medium text-sm text-gray-700">LinkedIn URL</label>
                                <input type="url" name="contact_linkedin" id="contact_linkedin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $li }}">
                            </div>
                            <div>
                                <label for="contact_youtube" class="block font-medium text-sm text-gray-700">YouTube URL</label>
                                <input type="url" name="contact_youtube" id="contact_youtube" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $yt }}">
                            </div>
                            <div>
                                <label for="contact_tiktok" class="block font-medium text-sm text-gray-700">TikTok URL</label>
                                <input type="url" name="contact_tiktok" id="contact_tiktok" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $tt }}">
                            </div>
                        </div>
                    </div>
                </div>
                </div>

                {{-- Midtrans Payment Gateway --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Midtrans Payment Gateway</h3>
                                <p class="text-xs text-gray-500">Konfigurasi pembayaran online via Midtrans</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="midtrans_merchant_id" class="block font-medium text-sm text-gray-700">Merchant ID</label>
                                <input type="text" name="midtrans_merchant_id" id="midtrans_merchant_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $midMerchant }}">
                            </div>
                            <div>
                                <label for="midtrans_client_key" class="block font-medium text-sm text-gray-700">Client Key</label>
                                <input type="text" name="midtrans_client_key" id="midtrans_client_key" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $midClientKey }}">
                            </div>
                        </div>
                        <div>
                            <label for="midtrans_server_key" class="block font-medium text-sm text-gray-700">Server Key</label>
                            <input type="text" name="midtrans_server_key" id="midtrans_server_key" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $midServerKey }}">
                        </div>
                        <div>
                            <input type="hidden" name="midtrans_is_production" value="0">
                            <label for="midtrans_is_production" class="flex items-center">
                                <input type="checkbox" name="midtrans_is_production" id="midtrans_is_production" value="1" {{ (string)$midIsProd === '1' ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">Aktifkan Mode Produksi (Live)</span>
                            </label>
                            <p class="mt-1 text-xs text-gray-500">Hanya aktifkan jika Anda sudah menggunakan akun Midtrans produksi (bukan sandbox).</p>
                        </div>
                    </div>
                </div>
                </div>

                {{-- Pengaturan Notifikasi WhatsApp (Pay at Hotel) --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">WhatsApp Integration</h3>
                                <p class="text-xs text-gray-500">Notifikasi WhatsApp untuk Pay at Hotel & Fonnte API</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                Fonnte API Configuration
                            </h4>
                            <label for="fonnte_api_key" class="block font-medium text-sm text-gray-700">Fonnte API Key (Token)</label>
                            <input type="text" name="fonnte_api_key" id="fonnte_api_key" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20" value="{{ old('fonnte_api_key', $settings['fonnte_api_key'] ?? '') }}" placeholder="Masukkan token Fonnte Anda di sini">
                        </div>

                        <hr class="border-gray-200">

                        <h4 class="text-md font-semibold text-gray-800 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Pay at Hotel Notifications
                        </h4>

                        <div>
                            <label for="whatsapp_admin_receiver" class="block font-medium text-sm text-gray-700">Nomor WA Admin Utama</label>
                            <input type="text" name="whatsapp_admin_receiver" id="whatsapp_admin_receiver" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20" value="{{ old('whatsapp_admin_receiver', $settings['whatsapp_admin_receiver'] ?? '') }}" placeholder="Contoh: 081234567890">
                        </div>
                        <div>
                            <label for="whatsapp_supervisor_receivers" class="block font-medium text-sm text-gray-700">Nomor WA Supervisor Tambahan (pisahkan dengan koma)</label>
                            <input type="text" name="whatsapp_supervisor_receivers" id="whatsapp_supervisor_receivers" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20" value="{{ old('whatsapp_supervisor_receivers', $settings['whatsapp_supervisor_receivers'] ?? '') }}" placeholder="Contoh: 0812..., 0813...">
                        </div>
                        <div>
                            <label for="whatsapp_pay_at_hotel_admin_template" class="block font-medium text-sm text-gray-700">Template Pesan ke Admin/Supervisor</label>
                            <textarea name="whatsapp_pay_at_hotel_admin_template" id="whatsapp_pay_at_hotel_admin_template" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20 font-mono text-sm" rows="6">{{ old('whatsapp_pay_at_hotel_admin_template', $settings['whatsapp_pay_at_hotel_admin_template'] ?? "🔔 *Booking Baru - Bayar di Hotel*\n\nSeorang tamu telah melakukan reservasi melalui afiliasi dan akan membayar di hotel.\n\n*Booking ID:* {booking_id}\n*Afiliasi:* {affiliate_name}\n\n*Detail Tamu:*\n*Nama:* {guest_name}\n*Telepon:* {guest_phone}\n*Email:* {guest_email}\n\n*Detail Menginap:*\n*Kamar:* {room_name}\n*Check-in:* {checkin_date}\n*Check-out:* {checkout_date}\n*Total Biaya:* {total_price}") }}</textarea>
                        </div>
                        <div>
                            <label for="whatsapp_pay_at_hotel_customer_template" class="block font-medium text-sm text-gray-700">Template Pesan ke Customer</label>
                            <textarea name="whatsapp_pay_at_hotel_customer_template" id="whatsapp_pay_at_hotel_customer_template" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20 font-mono text-sm" rows="4">{{ old('whatsapp_pay_at_hotel_customer_template', $settings['whatsapp_pay_at_hotel_customer_template'] ?? "Terima kasih, {guest_name}!\n\nBooking Anda di Bell Hotel Merauke dengan ID #{booking_id} telah kami konfirmasi.\n\nSilakan lakukan pembayaran saat Anda tiba di hotel. Kami tunggu kedatangan Anda!") }}</textarea>
                        </div>
                        <p class="mt-2 text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
                            <span class="font-semibold text-gray-700">Variabel yang tersedia:</span> <code class="bg-white px-2 py-1 rounded">{booking_id}</code>, <code class="bg-white px-2 py-1 rounded">{affiliate_name}</code>, <code class="bg-white px-2 py-1 rounded">{guest_name}</code>, <code class="bg-white px-2 py-1 rounded">{guest_phone}</code>, <code class="bg-white px-2 py-1 rounded">{guest_email}</code>, <code class="bg-white px-2 py-1 rounded">{room_name}</code>, <code class="bg-white px-2 py-1 rounded">{checkin_date}</code>, <code class="bg-white px-2 py-1 rounded">{checkout_date}</code>, <code class="bg-white px-2 py-1 rounded">{total_price}</code>
                        </p>

                        <hr class="border-gray-200">

                        <h4 class="text-md font-semibold text-gray-800 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Online Booking Confirmations
                        </h4>
                        <div>
                            <label for="whatsapp_customer_message" class="block font-medium text-sm text-gray-700">Template Pesan ke Pelanggan</label>
                            <textarea name="whatsapp_customer_message" id="whatsapp_customer_message" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20 font-mono text-sm" rows="5">{{ $waCustMsg }}</textarea>
                            <p class="mt-2 text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
                                <span class="font-semibold text-gray-700">Variabel yang tersedia:</span> <code class="bg-white px-2 py-1 rounded">{guest_name}</code>, <code class="bg-white px-2 py-1 rounded">{booking_id}</code>
                            </p>
                        </div>
                        <div>
                            <label for="whatsapp_admin_message" class="block font-medium text-sm text-gray-700">Template Pesan ke Admin</label>
                            <textarea name="whatsapp_admin_message" id="whatsapp_admin_message" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20 font-mono text-sm" rows="8">{{ $waAdminMsg }}</textarea>
                            <p class="mt-2 text-xs text-gray-500 bg-gray-50 p-3 rounded-lg">
                                <span class="font-semibold text-gray-700">Variabel yang tersedia:</span> <code class="bg-white px-2 py-1 rounded">{booking_id}</code>, <code class="bg-white px-2 py-1 rounded">{guest_name}</code>, <code class="bg-white px-2 py-1 rounded">{guest_phone}</code>, <code class="bg-white px-2 py-1 rounded">{guest_email}</code>, <code class="bg-white px-2 py-1 rounded">{checkin_date}</code>, <code class="bg-white px-2 py-1 rounded">{checkout_date}</code>
                            </p>
                        </div>
                    </div>
                </div>
                </div>

                {{-- Terms and Conditions --}}
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Terms and Conditions</h3>
                                <p class="text-xs text-gray-500">Syarat & ketentuan halaman booking</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                    <div>
                        <label for="terms_and_conditions_editor" class="block font-medium text-sm text-gray-700 mb-1">Page Content</label>
                        <textarea name="terms_and_conditions" id="terms_and_conditions_editor" class="form-control" rows="15">{{ old('terms_and_conditions', $settings['terms_and_conditions'] ?? '') }}</textarea>
                    </div>
                </div>
                </div>

                {{-- Save Button --}}
                <div class="sticky bottom-6 z-10">
                    <div class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 border border-admin-primary/30 rounded-2xl p-6 shadow-2xl">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <svg class="w-6 h-6 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Simpan Pengaturan</p>
                                    <p class="text-xs text-gray-600">Klik tombol untuk menyimpan semua perubahan</p>
                                </div>
                            </div>
                            <button type="submit" class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-admin-primary to-admin-secondary text-white rounded-xl hover:shadow-2xl hover:shadow-admin-primary/50 transition-all duration-300 font-bold text-lg">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Save All Settings
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        {{-- CKEditor 5 --}}
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                ClassicEditor
                    .create( document.querySelector( '#terms_and_conditions_editor' ) )
                    .catch( error => { console.error( error ); } );
            });
        </script>
    @endpush
</x-app-layout>