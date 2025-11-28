@extends('layouts.frontend')

@section('seo_title', $settings['contact_seo_title'] ?? 'Contact Us')
@section('meta_description', $settings['contact_seo_description'] ?? 'Get in touch with us. Find our address, phone number, and location on the map.')

@section('content')
<!-- Hero Section -->
<section class="contact-hero">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3 text-white" style="font-family: var(--heading-font); text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Contact Us</h1>
        <p class="lead mb-0 text-white mx-auto" style="max-width: 600px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            We are here to help. Reach out to us for any inquiries or assistance.
        </p>
    </div>
</section>

<!-- Contact Info Cards -->
<section class="featured-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- Address -->
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3 class="contact-label">Our Location</h3>
                    <p class="contact-value preserve-format">{{ $settings['contact_address'] ?? 'Address not available.' }}</p>
                </div>
            </div>
            
            <!-- Phone -->
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-phone-alt"></i>
                    </div>
                    <h3 class="contact-label">Phone Number</h3>
                    <div class="contact-value">
                        @if(!empty($settings['contact_phone']))
                            @php
                                $phone = $settings['contact_phone'];
                                $clean = preg_replace('/[^0-9]/', '', $phone);
                                $wa = substr($clean, 0, 1) === '0' ? '62' . substr($clean, 1) : $clean;
                            @endphp
                            <p class="mb-0">{{ $phone }}</p>
                            <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn btn-sm mt-3 rounded-pill px-4" style="background: linear-gradient(135deg, #87CEEB, #4682B4); color: white; border: none; box-shadow: 0 4px 15px rgba(135, 206, 235, 0.4);">
                                <i class="fab fa-whatsapp me-2"></i>Chat on WhatsApp
                            </a>
                        @else
                            Not available
                        @endif
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="col-md-4">
                <div class="contact-info-card">
                    <div class="contact-icon-wrapper">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3 class="contact-label">Email Address</h3>
                    <div class="contact-value">
                         @if(!empty($settings['contact_email']))
                            <a href="mailto:{{ $settings['contact_email'] }}">{{ $settings['contact_email'] }}</a>
                         @else
                            Not available
                         @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="featured-section alt-bg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="section-title">Find Us on Map</h2>
                    <p class="section-subtitle">Located in the heart of Merauke, our resort is easily accessible and surrounded by the natural beauty of Papua.</p>
                </div>
                <div class="map-container">
                     @if(!empty($settings['contact_maps_embed']))
                        {!! $settings['contact_maps_embed'] !!}
                    @else
                        <div class="d-flex justify-content-center align-items-center h-100 bg-light">
                            <p class="text-muted">Map not available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Inline override for map iframe to ensure it fits container */
    .map-container iframe {
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>
@endsection