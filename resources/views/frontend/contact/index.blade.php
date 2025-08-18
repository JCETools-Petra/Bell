@extends('layouts.frontend')

@section('seo_title', $settings['contact_seo_title'] ?? 'Contact Us')
@section('meta_description', $settings['contact_seo_description'] ?? 'Get in touch with us. Find our address, phone number, and location on the map.')

@section('content')
<style>
    .contact-map iframe {
        width: 100%;
        height: 100%;
        min-height: 450px;
        border: 0;
    }
</style>

{{-- TAMBAHKAN DIV PEMBUNGKUS INI --}}
<div class="page-content-wrapper"> 
    <div class="container my-5">
        <div class="text-center mb-5">
            <h1 class="display-4">Contact Us</h1>
            <p class="lead text-muted">We'd love to hear from you. Get in touch with us using the details below.</p>
        </div>

        <div class="row g-5">
            <div class="col-lg-6">
                <h3 class="mb-4">Our Address</h3>
                <p style="white-space: pre-wrap;">{{ $settings['contact_address'] ?? 'Address not available.' }}</p>
                
                <h3 class="mt-5 mb-4">Contact Details</h3>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <strong>Phone:</strong>
                            @if(!empty($settings['contact_phone']))
                                @php
                                    // Ambil nomor telepon asli yang diinput admin
                                    $originalPhone = $settings['contact_phone'];
                                    
                                    // 1. Hapus semua karakter selain angka (spasi, tanda hubung, dll.)
                                    $cleanedPhone = preg_replace('/[^0-9]/', '', $originalPhone);

                                    // 2. Cek jika nomor diawali dengan '0'
                                    if (substr($cleanedPhone, 0, 1) === '0') {
                                        // Ganti '0' di depan dengan kode negara '62'
                                        $waPhone = '62' . substr($cleanedPhone, 1);
                                    } else {
                                        // Jika sudah dalam format lain (misal: 628...), gunakan apa adanya
                                        $waPhone = $cleanedPhone;
                                    }
                                @endphp
                                {{-- Tampilkan nomor asli, tapi link-nya ke nomor yang sudah diformat --}}
                                <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener noreferrer">{{ $originalPhone }}</a>
                            @else
                                Phone not available.
                            @endif
                        </li>
                        <li>
                            <strong>Email:</strong> <a href="mailto:{{ $settings['contact_email'] ?? '' }}">{{ $settings['contact_email'] ?? 'Email not available.' }}</a>
                        </li>
                    </ul>
            </div>
            <div class="col-lg-6">
                <div class="contact-map shadow rounded overflow-hidden">
                    {!! $settings['contact_maps_embed'] ?? '<p class="p-5 text-center">Map not available.</p>' !!}
                </div>
            </div>
        </div>
    </div>
</div> {{-- JANGAN LUPA TAG PENUTUP DIV --}}
@endsection