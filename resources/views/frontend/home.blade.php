@extends('layouts.frontend')

@section('title', 'Welcome to Bell Hotel Merauke')

@section('content')
@php
    $heroBg = isset($settings['hero_image_path'])
              ? asset('storage/' . $settings['hero_image_path'])
              : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop';
@endphp

{{-- HERO SECTION --}}
<section class="hero-section" style="height: {{ $settings['hero_slider_height'] ?? 'auto' }};">
    @if($heroSliders->isNotEmpty())
        <div id="heroSlider" class="carousel slide hero-slider-background" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($heroSliders as $slider)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $slider->image_path) }}" class="d-block w-100" alt="Hero Background Image">
                    </div>
                @endforeach
            </div>
            @if($heroSliders->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#heroSlider" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroSlider" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
    @else
        <div class="hero-slider-background" style="background-image: url('{{ $heroBg }}'); background-size: cover; background-position: center;"></div>
    @endif

    <div class="container hero-content-overlay {{ $settings['hero_text_align'] ?? 'text-center' }}">
        <h1 class="display-3 fw-bold mb-3" style="
            font-size: {{ $settings['hero_title_font_size'] ?? '4.5' }}rem;
            font-family: {!! $settings['hero_title_font_family'] ?? 'var(--heading-font)' !!};
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        ">
            {{ $settings['hero_title'] ?? 'Bell Hotel Merauke' }}
        </h1>

        <p class="lead mb-4" style="
            font-size: {{ $settings['hero_subtitle_font_size'] ?? '1.5' }}rem;
            font-family: {!! $settings['hero_subtitle_font_family'] ?? 'var(--primary-font)' !!};
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
        ">
            {{ $settings['hero_subtitle'] ?? 'Elegance & Comfort in The Heart of The East.' }}
        </p>

        <div class="hero-booking-form mt-5 shadow-lg">
            <form action="{{ route('rooms.availability') }}" method="GET">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-3">
                        <label for="checkin" class="form-label text-white small text-uppercase ls-1">Check-in</label>
                        <input type="text" class="form-control datepicker" id="checkin" name="checkin" placeholder="Select Date" required>
                    </div>
                    <div class="col-lg-3">
                        <label for="checkout" class="form-label text-white small text-uppercase ls-1">Check-out</label>
                        <input type="text" class="form-control datepicker" id="checkout" name="checkout" placeholder="Select Date" required>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="guests" class="form-label text-white small text-uppercase ls-1">Guests</label>
                        <input type="number" class="form-control" id="guests" name="guests" value="1" min="1" required>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="rooms" class="form-label text-white small text-uppercase ls-1">Rooms</label>
                        <input type="number" class="form-control" id="rooms" name="rooms" value="1" min="1" required>
                    </div>
                    <div class="col-lg-2 d-grid">
                        <button type="submit" class="btn btn-custom h-100">Check</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- BANNER SECTION --}}
@if($banners->isNotEmpty())
<section class="banner-section py-5 bg-light">
    <div class="container">
        <div id="homepageBanner" class="carousel slide shadow-lg rounded overflow-hidden" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner">
                @foreach($banners as $banner)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        @if($banner->link_url) <a href="{{ $banner->link_url }}" target="_blank" rel="noopener"> @endif
                        <img src="{{ asset('storage/' . $banner->image_path) }}" class="d-block w-100" alt="Banner Image">
                        @if($banner->link_url) </a> @endif
                    </div>
                @endforeach
            </div>
            @if($banners->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#homepageBanner" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#homepageBanner" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
    </div>
</section>
@endif

<div id="featured-content">
    {{-- ABOUT SECTION --}}
    @if(isset($settings['show_about_section']) && $settings['show_about_section'] == '1')
    <section class="about-section-modern">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="about-title" style="font-family: {!! $settings['about_title_font_family'] ?? 'var(--heading-font)' !!};">
                        {{ $settings['about_title'] ?? 'Discover Our Story' }}
                    </h2>
                    <div class="about-text mt-4" style="font-family: {!! $settings['about_content_font_family'] ?? 'var(--primary-font)' !!};">
                        {{ $settings['about_content'] ?? 'Experience the finest hospitality in Merauke. Bell Hotel offers a perfect blend of luxury and comfort for both business and leisure travelers.' }}
                    </div>
                </div>
            </div>
            
            {{-- Features Grid --}}
            <div class="row mt-5 g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-icon-box">
                        <div class="feature-icon"><i class="fas fa-bed"></i></div>
                        <h5>Luxury Rooms</h5>
                        <p>Elegantly designed accommodations with premium amenities for your ultimate comfort and relaxation.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-icon-box">
                        <div class="feature-icon"><i class="fas fa-utensils"></i></div>
                        <h5>Fine Dining</h5>
                        <p>Savor exquisite culinary creations prepared by our award-winning chefs using the finest local ingredients.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-icon-box">
                        <div class="feature-icon"><i class="fas fa-wifi"></i></div>
                        <h5>High-Speed WiFi</h5>
                        <p>Stay seamlessly connected with complimentary high-speed internet access throughout the property.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="feature-icon-box">
                        <div class="feature-icon"><i class="fas fa-concierge-bell"></i></div>
                        <h5>24/7 Service</h5>
                        <p>Our dedicated concierge team is available around the clock to cater to your every need and request.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- FEATURED ROOMS - MODERN DESIGN --}}
    @if(in_array('rooms', $featuredOptions) && $featuredRooms->isNotEmpty())
        <section class="py-5" style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="badge bg-admin-primary text-white px-4 py-2 rounded-pill mb-3" style="font-size: 0.85rem; letter-spacing: 1px;">LUXURY STAYS</span>
                    <h2 class="section-title fw-bold mb-3" style="font-size: 2.5rem; color: #1e3a8a;">Featured Rooms</h2>
                    <p class="section-subtitle text-muted mx-auto" style="max-width: 600px; font-size: 1.1rem;">Experience unparalleled comfort in our meticulously designed rooms, where every detail speaks of luxury and sophistication.</p>
                </div>

                <div class="row g-4">
                    @foreach($featuredRooms as $room)
                        <div class="col-md-6 col-lg-4">
                            <div class="modern-room-card h-100 position-relative overflow-hidden rounded-4 shadow-lg" style="transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                                @if ($room->images->isNotEmpty())
                                    <div class="position-relative overflow-hidden" style="height: 320px;">
                                        <img src="{{ asset('storage/' . $room->images->first()->path) }}"
                                             class="w-100 h-100 object-fit-cover"
                                             alt="{{ $room->name }}"
                                             style="transition: transform 0.6s ease;">
                                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, transparent 0%, rgba(30, 58, 138, 0.7) 100%);"></div>
                                        <span class="position-absolute top-0 end-0 m-3 badge" style="background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.75rem; font-weight: 600;">FEATURED</span>
                                    </div>
                                @else
                                    <div style="height: 320px; background: linear-gradient(135deg, #1e3a8a 0%, #0ea5e9 100%);"></div>
                                @endif

                                <div class="p-4 bg-white">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="fw-bold mb-0" style="font-size: 1.4rem; color: #1e3a8a;">{{ $room->name }}</h5>
                                        <span class="badge bg-light text-admin-primary border border-admin-primary" style="font-size: 0.75rem;">
                                            <i class="fas fa-star me-1"></i>4.9
                                        </span>
                                    </div>

                                    <p class="text-muted mb-3" style="font-size: 0.95rem; line-height: 1.6;">{{ Str::limit($room->description, 90) }}</p>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-light text-dark px-3 py-2" style="font-size: 0.8rem; border-radius: 8px;">
                                            <i class="fas fa-wifi text-admin-secondary"></i> Free WiFi
                                        </span>
                                        <span class="badge bg-light text-dark px-3 py-2" style="font-size: 0.8rem; border-radius: 8px;">
                                            <i class="fas fa-tv text-admin-secondary"></i> Smart TV
                                        </span>
                                        <span class="badge bg-light text-dark px-3 py-2" style="font-size: 0.8rem; border-radius: 8px;">
                                            <i class="fas fa-shower text-admin-secondary"></i> Shower
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                        <div>
                                            <div class="text-muted small mb-1">Starting from</div>
                                            <div class="fw-bold" style="font-size: 1.6rem; background: linear-gradient(135deg, #1e3a8a 0%, #0ea5e9 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                                                Rp {{ number_format($room->price, 0, ',', '.') }}
                                                <span class="fs-6 text-muted fw-normal">/ night</span>
                                            </div>
                                        </div>
                                        <a href="{{ route('rooms.show', $room->slug) }}" class="btn btn-admin-primary rounded-pill px-4" style="font-weight: 600;">
                                            Book Now <i class="fas fa-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('rooms.index') }}" class="btn btn-outline-admin-primary btn-lg rounded-pill px-5" style="font-weight: 600; border-width: 2px;">
                        Explore All Rooms <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <style>
            .modern-room-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(30, 58, 138, 0.2) !important;
            }
            .modern-room-card:hover img {
                transform: scale(1.1);
            }
        </style>
    @endif

    {{-- FEATURED EVENT SPACES - MODERN DESIGN --}}
    @if(in_array('mice', $featuredOptions) && $featuredMice->isNotEmpty())
        <section class="py-5" style="background: linear-gradient(135deg, #1e3a8a 0%, #0ea5e9 100%); position: relative; overflow: hidden;">
            <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23ffffff%22 fill-opacity=%220.4%22%3E%3Cpath d=%22M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

            <div class="container position-relative">
                <div class="text-center mb-5">
                    <span class="badge text-white px-4 py-2 rounded-pill mb-3" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px); font-size: 0.85rem; letter-spacing: 1px;">EVENT VENUES</span>
                    <h2 class="fw-bold mb-3 text-white" style="font-size: 2.5rem;">Featured Event Spaces</h2>
                    <p class="text-white mx-auto opacity-90" style="max-width: 700px; font-size: 1.1rem;">Transform your vision into reality with our versatile event spaces, perfectly equipped for conferences, weddings, and corporate gatherings.</p>
                </div>

                <div class="row g-4">
                    @foreach($featuredMice as $mice)
                        <div class="col-md-6 col-lg-4">
                            <div class="modern-event-card position-relative overflow-hidden rounded-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                                @if ($mice->images->isNotEmpty())
                                    <div class="position-relative overflow-hidden" style="height: 280px;">
                                        <img src="{{ asset('storage/' . $mice->images->first()->path) }}"
                                             class="w-100 h-100 object-fit-cover"
                                             alt="{{ $mice->name }}"
                                             style="transition: transform 0.6s ease;">
                                        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.8) 100%);">
                                            <span class="badge bg-admin-accent text-dark px-3 py-2 mb-2" style="font-size: 0.75rem; font-weight: 600;">
                                                <i class="fas fa-star me-1"></i>POPULAR
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <div style="height: 280px; background: linear-gradient(135deg, #0ea5e9 0%, #06b6d4 100%);"></div>
                                @endif

                                <div class="p-4">
                                    <h5 class="fw-bold mb-3" style="font-size: 1.3rem; color: #1e3a8a;">{{ $mice->name }}</h5>

                                    <div class="row g-3 mb-3">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #0ea5e9;">
                                                    <i class="fas fa-users text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Capacity</div>
                                                    <div class="fw-bold text-admin-primary">{{ $mice->capacity_theatre ?? $mice->capacity_classroom }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2 p-3 rounded-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #fbbf24;">
                                                    <i class="fas fa-certificate text-white"></i>
                                                </div>
                                                <div>
                                                    <div class="small text-muted">Setup</div>
                                                    <div class="fw-bold" style="color: #92400e;">Theatre</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">{{ Str::limit($mice->description, 100) }}</p>

                                    <a href="{{ route('mice.show', $mice->slug) }}" class="btn w-100 rounded-pill" style="background: linear-gradient(135deg, #1e3a8a 0%, #0ea5e9 100%); color: white; font-weight: 600; padding: 0.75rem;">
                                        Request Inquiry <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('mice.index') }}" class="btn btn-light btn-lg rounded-pill px-5" style="font-weight: 600;">
                        View All Event Spaces <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <style>
            .modern-event-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3) !important;
            }
            .modern-event-card:hover img {
                transform: scale(1.1);
            }
        </style>
    @endif

    {{-- CULINARY EXCELLENCE - MODERN DESIGN --}}
    @if(in_array('restaurants', $featuredOptions) && $featuredRestaurantImages->isNotEmpty())
        <section id="restaurants" class="py-5" style="background: #ffffff;">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="badge bg-admin-accent text-dark px-4 py-2 rounded-pill mb-3" style="font-size: 0.85rem; letter-spacing: 1px;">DINING</span>
                    <h2 class="fw-bold mb-3" style="font-size: 2.5rem; color: #1e3a8a;">Culinary Excellence</h2>
                    <p class="text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem;">Embark on a gastronomic journey where each dish is a masterpiece, crafted with passion and the finest ingredients.</p>
                </div>

                <div class="row g-4 mb-4">
                    @foreach($featuredRestaurantImages->take(6) as $index => $image)
                        @if($image->restaurant)
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('restaurants.show', $image->restaurant->slug) }}" class="text-decoration-none">
                                    <div class="modern-culinary-card position-relative overflow-hidden rounded-4 shadow-lg" style="height: 350px; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                                        <img src="{{ asset('storage/' . $image->path) }}"
                                             class="w-100 h-100 object-fit-cover"
                                             alt="{{ $image->restaurant->name }}"
                                             style="transition: transform 0.6s ease;">

                                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, rgba(0,0,0,0.1) 0%, rgba(30, 58, 138, 0.8) 100%); transition: opacity 0.4s ease;"></div>

                                        <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white" style="transform: translateY(0); transition: transform 0.4s ease;">
                                            <span class="badge bg-admin-accent text-dark px-3 py-2 mb-2" style="font-size: 0.75rem; font-weight: 600;">
                                                <i class="fas fa-utensils me-1"></i>{{ $image->restaurant->name }}
                                            </span>
                                            <h5 class="fw-bold mb-2" style="font-size: 1.3rem;">Exquisite Flavors</h5>
                                            <p class="small mb-0 opacity-90">Discover culinary artistry</p>
                                        </div>

                                        <div class="position-absolute top-50 start-50 translate-middle" style="opacity: 0; transition: opacity 0.4s ease;">
                                            <div class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                <i class="fas fa-arrow-right fs-4"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('restaurants.index') }}" class="btn btn-admin-primary btn-lg rounded-pill px-5" style="font-weight: 600;">
                        Explore All Restaurants <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <style>
            .modern-culinary-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(30, 58, 138, 0.25) !important;
            }
            .modern-culinary-card:hover img {
                transform: scale(1.15);
            }
            .modern-culinary-card:hover .position-absolute.top-50 {
                opacity: 1 !important;
            }
            .modern-culinary-card:hover .position-absolute.bottom-0 {
                transform: translateY(10px);
            }
        </style>
    @endif

    {{-- RECREATION AREAS - NEW SECTION --}}
    @if($featuredRecreationAreas->isNotEmpty())
        <section class="py-5" style="background: linear-gradient(180deg, #f8f9fa 0%, #e0f2fe 100%); position: relative; overflow: hidden;">
            <div class="position-absolute" style="top: -50px; right: -50px; width: 300px; height: 300px; background: radial-gradient(circle, rgba(14, 165, 233, 0.1) 0%, transparent 70%);"></div>
            <div class="position-absolute" style="bottom: -100px; left: -100px; width: 400px; height: 400px; background: radial-gradient(circle, rgba(30, 58, 138, 0.1) 0%, transparent 70%);"></div>

            <div class="container position-relative">
                <div class="text-center mb-5">
                    <span class="badge bg-admin-tertiary text-white px-4 py-2 rounded-pill mb-3" style="font-size: 0.85rem; letter-spacing: 1px;">ACTIVITIES</span>
                    <h2 class="fw-bold mb-3" style="font-size: 2.5rem; color: #1e3a8a;">Recreation Areas</h2>
                    <p class="text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem;">Unwind and rejuvenate in our thoughtfully designed recreation spaces, perfect for relaxation and creating memorable moments.</p>
                </div>

                <div class="row g-4">
                    @foreach($featuredRecreationAreas as $recreation)
                        <div class="col-md-6 col-lg-4">
                            <div class="modern-recreation-card position-relative overflow-hidden rounded-4 shadow-lg bg-white" style="transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);">
                                @if ($recreation->images->isNotEmpty())
                                    <div class="position-relative overflow-hidden" style="height: 300px;">
                                        <img src="{{ asset('storage/' . $recreation->images->first()->path) }}"
                                             class="w-100 h-100 object-fit-cover"
                                             alt="{{ $recreation->name }}"
                                             style="transition: transform 0.6s ease;">

                                        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.6) 100%); opacity: 0.7;"></div>

                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge px-3 py-2" style="background: rgba(6, 182, 212, 0.9); backdrop-filter: blur(10px); font-size: 0.75rem; font-weight: 600; border-radius: 2rem;">
                                                <i class="fas fa-umbrella-beach me-1"></i>RELAXATION
                                            </span>
                                        </div>

                                        <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white">
                                            <h5 class="fw-bold mb-1" style="font-size: 1.5rem; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">{{ $recreation->name }}</h5>
                                        </div>
                                    </div>
                                @else
                                    <div style="height: 300px; background: linear-gradient(135deg, #06b6d4 0%, #0ea5e9 100%);"></div>
                                @endif

                                <div class="p-4">
                                    <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">{{ Str::limit($recreation->description, 120) }}</p>

                                    <div class="row g-2 mb-4">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background: #f0f9ff;">
                                                <i class="fas fa-map-marker-alt text-admin-tertiary"></i>
                                                <span class="small text-muted">{{ $recreation->location ?? 'Hotel Area' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background: #fef3c7;">
                                                <i class="fas fa-clock text-admin-accent"></i>
                                                <span class="small text-muted">Open Daily</span>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('recreation-areas.show', $recreation->slug) }}" class="btn btn-outline-admin-tertiary w-100 rounded-pill" style="font-weight: 600; border-width: 2px;">
                                        Learn More <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-5">
                    <a href="{{ route('recreation-areas.index') }}" class="btn btn-admin-tertiary btn-lg rounded-pill px-5 text-white" style="font-weight: 600;">
                        View All Recreation Areas <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </section>

        <style>
            .modern-recreation-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(6, 182, 212, 0.25) !important;
            }
            .modern-recreation-card:hover img {
                transform: scale(1.1) rotate(2deg);
            }
        </style>
    @endif
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log("Inline Calendar Script Loaded");

        if (typeof flatpickr === "undefined") {
            console.error("Flatpickr is not loaded.");
            return;
        }

        // Inject CSS directly
        const style = document.createElement('style');
        style.innerHTML = `
            .flatpickr-day {
                display: flex !important;
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                height: auto !important;
                min-height: 60px !important;
                line-height: normal !important;
                padding: 4px 0 !important;
            }
            .day-number {
                font-size: 14px !important;
                font-weight: bold !important;
                margin-bottom: 2px;
            }
            .day-price {
                font-size: 10px !important;
                font-weight: 600 !important;
                color: #28a745;
                line-height: 1.2 !important;
            }
            .flatpickr-day.selected .day-price {
                color: #fff !important;
            }
        `;
        document.head.appendChild(style);

        // Mock API Fetch for debugging if real API fails
        async function getPricesForMonth(year, month) {
            try {
                let url = `/api/room-prices/month?year=${year}&month=${month + 1}`;
                const response = await fetch(url);
                if (!response.ok) throw new Error('Network response was not ok');
                return await response.json();
            } catch (error) {
                console.error('Error fetching prices:', error);
                return {}; 
            }
        }

        const fpConfig = {
            dateFormat: "d-m-Y",
            minDate: "today",
            onReady: async function (selectedDates, dateStr, instance) {
                const prices = await getPricesForMonth(instance.currentYear, instance.currentMonth);
                instance.prices = prices;
                instance.redraw();
            },
            onMonthChange: async function (selectedDates, dateStr, instance) {
                const prices = await getPricesForMonth(instance.currentYear, instance.currentMonth);
                instance.prices = prices;
                instance.redraw();
            },
            onDayCreate: function (dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj;
                const dateString = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                
                // Clear and re-structure
                const dayNumber = date.getDate();
                dayElem.innerHTML = `<span class="day-number">${dayNumber}</span>`;

                // Check for price data
                if (fp.prices && fp.prices[dateString]) {
                    const priceInfo = fp.prices[dateString];
                    const priceElement = document.createElement('span');
                    priceElement.className = 'day-price';
                    const shortPrice = parseInt(priceInfo.price / 1000) + 'k';
                    priceElement.textContent = shortPrice;
                    if (priceInfo.is_special) priceElement.style.color = '#e11d48';
                    dayElem.appendChild(priceElement);
                } else {
                     // DEBUG: Show dummy if no price found to verify layout
                     const dummy = document.createElement('span');
                     dummy.className = 'day-price';
                     dummy.textContent = '---';
                     dummy.style.color = '#ccc';
                     dayElem.appendChild(dummy);
                }
            }
        };

        flatpickr(".datepicker", fpConfig);
    });
</script>
@endpush