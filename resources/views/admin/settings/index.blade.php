<x-app-layout>
    {{-- Slot untuk header halaman --}}
    <x-slot name="header">
        <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
            {{ __('Website Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PUT')
                {{-- Method spoofing for POST request --}}

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
                        <i class="fas fa-check-circle text-xl"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl shadow-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
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

                    $waCustMsg    = old('whatsapp_customer_message', $settings['whatsapp_customer_message'] ?? 'Terima kasih! Pembayaran untuk booking ID: {booking_id} telah kami terima. Kamar Anda telah berhasil dipesan. Kami tunggu kedatangan Anda di Sora Hotel Merauke.');
                    $waAdminMsg   = old('whatsapp_admin_message', $settings['whatsapp_admin_message'] ?? "✅ *Konfirmasi Pembayaran Baru!*\n\n*Booking ID:* {booking_id}\n*Nama Tamu:* {guest_name}\n*Telepon:* {guest_phone}\n*Email:* {guest_email}\n*Check-in:* {checkin_date}\n*Check-out:* {checkout_date}");

                    $currentMethod = old('booking_method', $settings['booking_method'] ?? 'direct');

                    // Variabel untuk Running Text
                    $runningTextEnabled = old('running_text_enabled', $settings['running_text_enabled'] ?? '0');
                    $runningTextContent = old('running_text_content', $settings['running_text_content'] ?? '');
                    $runningTextUrl     = old('running_text_url', $settings['running_text_url'] ?? '');
                @endphp
                
                {{-- General Settings --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-cogs text-brand-primary"></i> General Settings
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="website_title" class="block font-bold text-sm text-gray-700 mb-2">Website Title</label>
                                <input type="text" name="website_title" id="website_title" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $websiteTitle }}" required>
                            </div>
                            <div>
                                <label for="logo_height" class="block font-bold text-sm text-gray-700 mb-2">Logo Height (px)</label>
                                <input type="number" name="logo_height" id="logo_height" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $logoHeight }}" required>
                            </div>
                            <div>
                                <label for="logo" class="block font-bold text-sm text-gray-700 mb-2">Upload Logo</label>
                                <input type="file" name="logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-primary file:text-white hover:file:bg-brand-dark transition-all cursor-pointer">
                                @if(isset($settings['logo_path']))
                                    <div class="mt-3 p-2 bg-gray-50 rounded-xl border border-gray-200 inline-block">
                                        <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="Current Logo" class="h-12 object-contain">
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label for="favicon" class="block font-bold text-sm text-gray-700 mb-2">Upload Favicon</label>
                                <input type="file" name="favicon" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-primary file:text-white hover:file:bg-brand-dark transition-all cursor-pointer">
                                @if(isset($settings['favicon_path']))
                                    <div class="mt-3 p-2 bg-gray-50 rounded-xl border border-gray-200 inline-block">
                                        <img src="{{ asset('storage/' . $settings['favicon_path']) }}" alt="Current Favicon" class="h-8 object-contain">
                                    </div>
                                @endif
                            </div>
                            <div class="md:col-span-2">
                                <input type="hidden" name="show_logo_text" value="0">
                                <label for="show_logo_text" class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="show_logo_text" id="show_logo_text" value="1" {{ (string)$showLogoText === '1' ? 'checked' : '' }} class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary transition-all w-5 h-5">
                                    <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-primary transition-colors">Show Website Title next to Logo</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Running Text Announcement --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-bullhorn text-brand-primary"></i> Running Text Announcement
                        </h3>
                        <div class="mb-6">
                            <input type="hidden" name="running_text_enabled" value="0">
                            <label for="running_text_enabled" class="flex items-center cursor-pointer group">
                                <input type="checkbox" name="running_text_enabled" id="running_text_enabled" value="1" {{ (string)$runningTextEnabled === '1' ? 'checked' : '' }} class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary transition-all w-5 h-5">
                                <span class="ml-3 text-sm font-medium text-gray-700 group-hover:text-brand-primary transition-colors">Aktifkan Running Text</span>
                            </label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="running_text_content" class="block font-bold text-sm text-gray-700 mb-2">Teks yang Ditampilkan</label>
                                <input type="text" name="running_text_content" id="running_text_content" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $runningTextContent }}">
                            </div>
                            <div>
                                <label for="running_text_url" class="block font-bold text-sm text-gray-700 mb-2">Link URL (jika diklik)</label>
                                <input type="url" name="running_text_url" id="running_text_url" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $runningTextUrl }}" placeholder="https://contoh.com/promo">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MICE Layout Icons --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-th-large text-brand-primary"></i> MICE Layout Icons
                        </h3>
                        <p class="text-sm text-gray-600 mb-6 bg-blue-50 p-4 rounded-xl border border-blue-100 flex items-center gap-2">
                            <i class="fas fa-info-circle text-blue-500"></i>
                            Upload an icon for each MICE room layout. These icons will be displayed on all MICE detail pages.
                        </p>
                        
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
                            <div class="border border-gray-200 p-6 rounded-2xl hover:shadow-md transition-shadow bg-gray-50/50">
                                <label for="{{ $key }}" class="block text-sm font-bold text-gray-700 mb-3">{{ $label }}</label>
                                <input type="file" name="{{ $key }}" id="{{ $key }}" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-brand-primary file:text-white hover:file:bg-brand-dark transition-all cursor-pointer"/>
                                
                                @if(isset($settings[$key]) && $settings[$key])
                                <div class="mt-4 flex items-center gap-3 bg-white p-3 rounded-xl border border-gray-100">
                                    <img src="{{ asset('storage/' . $settings[$key]) }}" class="h-12 w-12 object-contain">
                                    <span class="text-xs text-gray-500 font-medium">Current Icon</span>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Metode Booking --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-calendar-check text-brand-primary"></i> Metode Booking
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="booking_method" class="block font-bold text-sm text-gray-700 mb-2">Metode Booking Aktif</label>
                                <select name="booking_method" id="booking_method" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all">
                                    <option value="direct" {{ $currentMethod === 'direct' ? 'selected' : '' }}>
                                        Direct Booking (Pembayaran via Midtrans)
                                    </option>
                                    <option value="manual" {{ $currentMethod === 'manual' ? 'selected' : '' }}>
                                        Manual Booking (Follow-up via WhatsApp)
                                    </option>
                                </select>
                                <p class="mt-2 text-xs text-gray-500">Pilih metode yang akan digunakan oleh pelanggan di halaman depan.</p>
                                <div class="mt-3 text-sm">
                                    @if($currentMethod === 'manual')
                                        <div class="px-4 py-3 rounded-xl bg-yellow-50 text-yellow-800 border border-yellow-200 flex items-start gap-2">
                                            <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                            <span>Saat ini: <strong>Manual</strong> — form booking akan mengirim notifikasi WhatsApp ke admin (tanpa halaman pembayaran).</span>
                                        </div>
                                    @else
                                        <div class="px-4 py-3 rounded-xl bg-blue-50 text-blue-800 border border-blue-200 flex items-start gap-2">
                                            <i class="fas fa-info-circle mt-0.5"></i>
                                            <span>Saat ini: <strong>Direct</strong> — pelanggan akan diarahkan ke pembayaran Midtrans.</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Homepage Hero Section --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-image text-brand-primary"></i> Homepage Hero Section
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label for="hero_title" class="block font-bold text-sm text-gray-700 mb-2">Hero Title</label>
                                <input type="text" name="hero_title" id="hero_title" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $heroTitle }}">
                            </div>
                            <div>
                                <label for="hero_subtitle" class="block font-bold text-sm text-gray-700 mb-2">Hero Subtitle</label>
                                <textarea name="hero_subtitle" id="hero_subtitle" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" rows="3">{{ $heroSubtitle }}</textarea>
                            </div>
                            <div>
                                <label for="hero_image" class="block font-bold text-sm text-gray-700 mb-2">Hero Background Image</label>
                                <input type="file" name="hero_image" id="hero_image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-brand-primary file:text-white hover:file:bg-brand-dark transition-all cursor-pointer">
                                @if(isset($settings['hero_image_path']))
                                    <div class="mt-4 rounded-xl overflow-hidden border border-gray-200 inline-block shadow-sm">
                                        <img src="{{ asset('storage/' . $settings['hero_image_path']) }}" alt="Current Hero Image" class="w-64 object-cover">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Contact & Social Media --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-address-book text-brand-primary"></i> Contact & Social Media
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label for="contact_address" class="block font-bold text-sm text-gray-700 mb-2">Address</label>
                                <input type="text" name="contact_address" id="contact_address" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $addr }}">
                            </div>
                            <div>
                                <label for="contact_maps_embed" class="block font-bold text-sm text-gray-700 mb-2">Google Maps Embed Code</label>
                                <textarea name="contact_maps_embed" id="contact_maps_embed" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all font-mono text-xs" rows="4">{{ $mapsEmbed }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">Buka Google Maps, cari lokasi Anda, klik "Share", lalu "Embed a map", dan salin kode HTML-nya ke sini.</p>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="contact_phone" class="block font-bold text-sm text-gray-700 mb-2">Phone Number</label>
                                    <input type="text" name="contact_phone" id="contact_phone" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $phone }}">
                                </div>
                                <div>
                                    <label for="contact_email" class="block font-bold text-sm text-gray-700 mb-2">Email Address</label>
                                    <input type="email" name="contact_email" id="contact_email" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $email }}">
                                </div>
                            </div>
                            
                            <div class="pt-6 border-t border-gray-100">
                                <h4 class="text-lg font-bold text-gray-800 mb-4">Social Media Links</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="contact_facebook" class="block font-bold text-sm text-gray-700 mb-2">Facebook URL</label>
                                        <input type="url" name="contact_facebook" id="contact_facebook" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $fb }}">
                                    </div>
                                    <div>
                                        <label for="contact_instagram" class="block font-bold text-sm text-gray-700 mb-2">Instagram URL</label>
                                        <input type="url" name="contact_instagram" id="contact_instagram" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $ig }}">
                                    </div>
                                    <div>
                                        <label for="contact_linkedin" class="block font-bold text-sm text-gray-700 mb-2">LinkedIn URL</label>
                                        <input type="url" name="contact_linkedin" id="contact_linkedin" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $li }}">
                                    </div>
                                    <div>
                                        <label for="contact_youtube" class="block font-bold text-sm text-gray-700 mb-2">YouTube URL</label>
                                        <input type="url" name="contact_youtube" id="contact_youtube" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $yt }}">
                                    </div>
                                    <div>
                                        <label for="contact_tiktok" class="block font-bold text-sm text-gray-700 mb-2">TikTok URL</label>
                                        <input type="url" name="contact_tiktok" id="contact_tiktok" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $tt }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Midtrans Payment Gateway --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-credit-card text-brand-primary"></i> Midtrans Payment Gateway
                        </h3>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="midtrans_merchant_id" class="block font-bold text-sm text-gray-700 mb-2">Merchant ID</label>
                                    <input type="text" name="midtrans_merchant_id" id="midtrans_merchant_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $midMerchant }}">
                                </div>
                                <div>
                                    <label for="midtrans_client_key" class="block font-bold text-sm text-gray-700 mb-2">Client Key</label>
                                    <input type="text" name="midtrans_client_key" id="midtrans_client_key" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $midClientKey }}">
                                </div>
                            </div>
                            <div>
                                <label for="midtrans_server_key" class="block font-bold text-sm text-gray-700 mb-2">Server Key</label>
                                <input type="text" name="midtrans_server_key" id="midtrans_server_key" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ $midServerKey }}">
                            </div>
                            <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <input type="hidden" name="midtrans_is_production" value="0">
                                <label for="midtrans_is_production" class="flex items-center cursor-pointer group">
                                    <input type="checkbox" name="midtrans_is_production" id="midtrans_is_production" value="1" {{ (string)$midIsProd === '1' ? 'checked' : '' }} class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary transition-all w-5 h-5">
                                    <span class="ml-3 text-sm font-bold text-gray-700 group-hover:text-brand-primary transition-colors">Aktifkan Mode Produksi (Live)</span>
                                </label>
                                <p class="mt-2 ml-8 text-xs text-gray-500">Hanya aktifkan jika Anda sudah menggunakan akun Midtrans produksi (bukan sandbox).</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Fonnte API Key --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-key text-brand-primary"></i> Fonnte API Key
                        </h3>
                        <div>
                            <label for="fonnte_api_key" class="block font-bold text-sm text-gray-700 mb-2">Fonnte API Key (Token)</label>
                            <input type="text" name="fonnte_api_key" id="fonnte_api_key" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ old('fonnte_api_key', $settings['fonnte_api_key'] ?? '') }}" placeholder="Masukkan token Fonnte Anda di sini">
                        </div>
                    </div>
                </div>

                {{-- Pengaturan Notifikasi WhatsApp (Pay at Hotel) --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fab fa-whatsapp text-brand-primary"></i> Notifikasi WhatsApp (Pay at Hotel)
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label for="whatsapp_admin_receiver" class="block font-bold text-sm text-gray-700 mb-2">Nomor WA Admin Utama</label>
                                <input type="text" name="whatsapp_admin_receiver" id="whatsapp_admin_receiver" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ old('whatsapp_admin_receiver', $settings['whatsapp_admin_receiver'] ?? '') }}" placeholder="Contoh: 081234567890">
                            </div>
                            <div>
                                <label for="whatsapp_supervisor_receivers" class="block font-bold text-sm text-gray-700 mb-2">Nomor WA Supervisor Tambahan (pisahkan dengan koma)</label>
                                <input type="text" name="whatsapp_supervisor_receivers" id="whatsapp_supervisor_receivers" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" value="{{ old('whatsapp_supervisor_receivers', $settings['whatsapp_supervisor_receivers'] ?? '') }}" placeholder="Contoh: 0812..., 0813...">
                            </div>
                            <div>
                                <label for="whatsapp_pay_at_hotel_admin_template" class="block font-bold text-sm text-gray-700 mb-2">Template Pesan ke Admin/Supervisor</label>
                                <textarea name="whatsapp_pay_at_hotel_admin_template" id="whatsapp_pay_at_hotel_admin_template" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all font-mono text-xs" rows="6">{{ old('whatsapp_pay_at_hotel_admin_template', $settings['whatsapp_pay_at_hotel_admin_template'] ?? "🔔 *Booking Baru - Bayar di Hotel*\n\nSeorang tamu telah melakukan reservasi melalui afiliasi dan akan membayar di hotel.\n\n*Booking ID:* {booking_id}\n*Afiliasi:* {affiliate_name}\n\n*Detail Tamu:*\n*Nama:* {guest_name}\n*Telepon:* {guest_phone}\n*Email:* {guest_email}\n\n*Detail Menginap:*\n*Kamar:* {room_name}\n*Check-in:* {checkin_date}\n*Check-out:* {checkout_date}\n*Total Biaya:* {total_price}") }}</textarea>
                            </div>
                            <div>
                                <label for="whatsapp_pay_at_hotel_customer_template" class="block font-bold text-sm text-gray-700 mb-2">Template Pesan ke Customer</label>
                                <textarea name="whatsapp_pay_at_hotel_customer_template" id="whatsapp_pay_at_hotel_customer_template" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all font-mono text-xs" rows="4">{{ old('whatsapp_pay_at_hotel_customer_template', $settings['whatsapp_pay_at_hotel_customer_template'] ?? "Terima kasih, {guest_name}!\n\nBooking Anda di Sora Hotel Merauke dengan ID #{booking_id} telah kami konfirmasi.\n\nSilakan lakukan pembayaran saat Anda tiba di hotel. Kami tunggu kedatangan Anda!") }}</textarea>
                            </div>
                            <p class="text-xs text-gray-500 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                Variabel yang tersedia: <code>{booking_id}</code>, <code>{affiliate_name}</code>, <code>{guest_name}</code>, <code>{guest_phone}</code>, <code>{guest_email}</code>, <code>{room_name}</code>, <code>{checkin_date}</code>, <code>{checkout_date}</code>, <code>{total_price}</code>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Pengaturan Notifikasi WhatsApp --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fab fa-whatsapp text-brand-primary"></i> Pengaturan Notifikasi WhatsApp (Direct Booking)
                        </h3>
                        <div class="space-y-6">
                            <div>
                                <label for="whatsapp_customer_message" class="block font-bold text-sm text-gray-700 mb-2">Template Pesan ke Pelanggan</label>
                                <textarea name="whatsapp_customer_message" id="whatsapp_customer_message" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all font-mono text-xs" rows="5">{{ $waCustMsg }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">
                                    Variabel yang tersedia: <code>{guest_name}</code>, <code>{booking_id}</code>
                                </p>
                            </div>
                            <div>
                                <label for="whatsapp_admin_message" class="block font-bold text-sm text-gray-700 mb-2">Template Pesan ke Admin</label>
                                <textarea name="whatsapp_admin_message" id="whatsapp_admin_message" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all font-mono text-xs" rows="8">{{ $waAdminMsg }}</textarea>
                                <p class="mt-2 text-xs text-gray-500">
                                    Variabel yang tersedia: <code>{booking_id}</code>, <code>{guest_name}</code>, <code>{guest_phone}</code>, <code>{guest_email}</code>, <code>{checkin_date}</code>, <code>{checkout_date}</code>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- MICE Commission Rate --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-percentage text-brand-primary"></i> MICE Commission Settings
                        </h3>
                        <div class="space-y-4">
                            <div>
                                <label for="mice_commission_rate" class="block font-bold text-sm text-gray-700 mb-2">MICE Commission Rate (%)</label>
                                <div class="relative rounded-xl shadow-sm">
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        name="mice_commission_rate"
                                        id="mice_commission_rate"
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all pr-12"
                                        value="{{ old('mice_commission_rate', $settings['mice_commission_rate'] ?? '2.5') }}"
                                        required
                                    >
                                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                        <span class="text-gray-500 font-bold">%</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">
                                    Komisi yang akan diterima affiliate untuk setiap booking MICE yang berhasil. Default: 2.5%
                                </p>
                                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-yellow-800 text-sm flex items-start gap-3">
                                    <i class="fas fa-exclamation-triangle mt-0.5"></i>
                                    <div>
                                        <p class="font-bold">Penting:</p>
                                        <p class="mt-1">Commission rate ini <strong>dilindungi</strong> dan tidak dapat diubah oleh affiliate di frontend. Hanya admin yang dapat mengatur nilai ini.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Terms and Conditions --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <h3 class="text-xl font-heading font-bold text-brand-dark border-b border-gray-100 pb-4 mb-6 flex items-center gap-2">
                            <i class="fas fa-file-contract text-brand-primary"></i> Terms and Conditions Page
                        </h3>
                        <div>
                            <label for="terms_and_conditions_editor" class="block font-bold text-sm text-gray-700 mb-2">Page Content</label>
                            <textarea name="terms_and_conditions" id="terms_and_conditions_editor" class="form-control" rows="15">{{ old('terms_and_conditions', $settings['terms_and_conditions'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6">
                    <button type="submit" class="inline-flex items-center px-8 py-3 bg-brand-primary border border-transparent rounded-xl font-bold text-white uppercase tracking-widest hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand-primary focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-brand-primary/30 transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i> Save Settings
                    </button>
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
