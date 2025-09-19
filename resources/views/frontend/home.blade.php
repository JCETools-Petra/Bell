@extends('layouts.frontend')

@section('title', 'Welcome to Bell Hotel Merauke')

@section('content')
@php
    // BENAR: Menggunakan kunci '_path' yang disimpan oleh controller
    $heroBg = isset($settings['hero_image_path'])
              ? asset('storage/' . $settings['hero_image_path'])
              : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop';
@endphp

<section class="hero-section" style="background-image: url('{{ $heroBg }}');">
    <div class="container {{ $settings['hero_text_align'] ?? 'text-center' }}">
        <h1 class="display-3" style="
            font-size: {{ $settings['hero_title_font_size'] ?? '4.5' }}rem;
            font-family: {!! $settings['hero_title_font_family'] ?? 'var(--heading-font)' !!};
        ">
            {{ $settings['hero_title'] ?? 'Bell Hotel Merauke' }}
        </h1>

        <p class="lead" style="
            font-size: {{ $settings['hero_subtitle_font_size'] ?? '1.5' }}rem;
            font-family: {!! $settings['hero_subtitle_font_family'] ?? 'var(--primary-font)' !!};
        ">
            {{ $settings['hero_subtitle'] ?? 'Elegance & Comfort in The Heart of The East.' }}
        </p>

        <div class="hero-booking-form mt-4">
            <form action="{{ route('rooms.availability') }}" method="GET">
                <div class="row g-2 align-items-center">
                    <div class="col-lg-3">
                        <label for="checkin" class="form-label">Check-in</label>
                        <input type="text" class="form-control datepicker" id="checkin" name="checkin" placeholder="Select Date" required>
                    </div>
                    <div class="col-lg-3">
                        <label for="checkout" class="form-label">Check-out</label>
                        <input type="text" class="form-control datepicker" id="checkout" name="checkout" placeholder="Select Date" required>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="guests" class="form-label">Guests</label>
                        <input type="number" class="form-control" id="guests" name="guests" value="1" min="1" required>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <label for="rooms" class="form-label">Rooms</label>
                        <input type="number" class="form-control" id="rooms" name="rooms" value="1" min="1" required>
                    </div>
                    <div class="col-lg-2 d-grid">
                        <button type="submit" class="btn btn-custom">Check Availability</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@if($banners->isNotEmpty())
<section class="banner-section py-5">
    <div class="container">
        <div id="homepageBanner" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            <div class="carousel-inner" style="border-radius: 10px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
                @foreach($banners as $banner)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        @if($banner->link_url)
                            <a href="{{ $banner->link_url }}" target="_blank" rel="noopener">
                        @endif

                        <img src="{{ asset('storage/' . $banner->image_path) }}" class="d-block w-100" alt="Banner Image">

                        @if($banner->link_url)
                            </a>
                        @endif
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

<div class="container" id="featured-content">
    @if(isset($settings['show_about_section']) && $settings['show_about_section'] == '1')
    <section class="about-section {{ $settings['about_text_align'] ?? 'text-center' }}">
        <h2 class="section-title" style="
            font-size: {{ $settings['about_title_font_size'] ?? '2.8' }}rem;
            font-family: {!! $settings['about_title_font_family'] ?? 'var(--heading-font)' !!};
        ">
            {{ $settings['about_title'] ?? 'Discover Our Story' }}
        </h2>
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <p style="
                    font-size: {{ $settings['about_content_font_size'] ?? '1' }}rem;
                    font-family: {!! $settings['about_content_font_family'] ?? 'var(--primary-font)' !!};
                ">
                    {{ $settings['about_content'] ?? 'Lorem ipsum dolor sit amet...' }}
                </p>
            </div>
        </div>
    </section>
    @endif

    {{-- Logika baru untuk menampilkan konten berdasarkan array --}}
    @if(in_array('rooms', $featuredOptions) && $featuredRooms->isNotEmpty())
        <section class="featured-section">
            <h2 class="section-title text-center mb-5">Featured Rooms</h2>
            <div class="row justify-content-center">
                @foreach($featuredRooms as $room)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $room->images->first() ? asset('storage/' . $room->images->first()->path) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $room->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title h3">{{ $room->name }}</h5>
                                <p class="card-price mb-3">Rp {{ number_format($room->price, 0, ',', '.') }} / night</p>
                                <p class="card-text">{{ Str::limit($room->description, 100) }}</p>
                                <a href="{{ route('rooms.show', $room->slug) }}" class="btn btn-custom mt-auto">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if(in_array('mice', $featuredOptions) && $featuredMice->isNotEmpty())
        <section class="featured-section">
            <h2 class="section-title text-center mb-5">Featured Event Spaces</h2>
            <div class="row justify-content-center">
                @foreach($featuredMice as $mice)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ $mice->images->first() ? asset('storage/' . $mice->images->first()->path) : 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $mice->name }}">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title h3">{{ $mice->name }}</h5>
                                <p class="card-price mb-3">Capacity up to <strong>{{ $mice->capacity_theatre ?? $mice->capacity_classroom }} persons</strong></p>
                                <p class="card-text">{{ Str::limit($mice->description, 100) }}</p>
                                <a href="{{ route('mice.show', $mice->slug) }}" class="btn btn-custom mt-auto">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    @if(in_array('restaurants', $featuredOptions) && $featuredRestaurants->isNotEmpty())
        <section id="restaurants" class="py-5">
            <div class="container">
                <h2 class="section-title text-center mb-4">Our Restaurants</h2>
                <div class="row">
                    @php
                        $restaurantsCount = count($featuredRestaurants);
                    @endphp
                    @forelse ($featuredRestaurants as $restaurant)
                        <div class="
                            @if ($restaurantsCount === 1)
                                col-md-6 offset-md-3
                            @else
                                col-lg-4 col-md-6
                            @endif
                            mb-4">
                            <div class="card h-100">
                                @if ($restaurant->images->isNotEmpty())
                                    <img class="card-img-top" src="{{ asset('storage/' . $restaurant->images->first()->path) }}" alt="{{ $restaurant->name }}">
                                @else
                                    <img class="card-img-top" src="https://via.placeholder.com/400x250?text=No+Image" alt="{{ $restaurant->name }}">
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title">{{ $restaurant->name }}</h4>
                                    <p class="card-text">{{ $restaurant->description }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>No restaurants found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    @endif
</div>
@endsection