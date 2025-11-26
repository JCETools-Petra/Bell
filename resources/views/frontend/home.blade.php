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

    {{-- FEATURED ROOMS --}}
    @if(in_array('rooms', $featuredOptions) && $featuredRooms->isNotEmpty())
        <section class="featured-section alt-bg">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Featured Rooms</h2>
                    <p class="section-subtitle">Discover our handpicked selection of luxurious accommodations, each designed to provide the ultimate comfort and elegance for your stay.</p>
                </div>
                
                <div class="row g-4 justify-content-center">
                    @foreach($featuredRooms as $room)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <span class="card-badge">Featured</span>
                                @if ($room->images->isNotEmpty())
                                    <div id="roomSlider{{ $room->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4000">
                                        <div class="carousel-inner">
                                            @foreach($room->images as $image)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100 card-img-top" alt="{{ $room->name }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($room->images->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#roomSlider{{ $room->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#roomSlider{{ $room->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="{{ $room->name }}">
                                @endif
                                
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title h3 mb-2" style="font-family: var(--heading-font);">{{ $room->name }}</h5>
                                    <p class="card-price fw-bold mb-3" style="background: linear-gradient(135deg, #87CEEB, #4682B4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Rp {{ number_format($room->price, 0, ',', '.') }} <span class="text-muted small fw-normal">/ night</span></p>
                                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($room->description, 100) }}</p>
                                    <a href="{{ route('rooms.show', $room->slug) }}" class="btn btn-custom mt-3 w-100">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- FEATURED MICE --}}
    @if(in_array('mice', $featuredOptions) && $featuredMice->isNotEmpty())
        <section class="featured-section">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Featured Event Spaces</h2>
                    <p class="section-subtitle">Host memorable events in our state-of-the-art venues, equipped with cutting-edge technology and elegant design to ensure your gathering is a resounding success.</p>
                </div>

                <div class="row g-4 justify-content-center">
                    @foreach($featuredMice as $mice)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100">
                                <span class="card-badge">Popular</span>
                                @if ($mice->images->isNotEmpty())
                                    <div id="miceSlider{{ $mice->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="4500">
                                        <div class="carousel-inner">
                                            @foreach($mice->images as $image)
                                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                    <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100 card-img-top" alt="{{ $mice->name }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        @if($mice->images->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#miceSlider{{ $mice->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#miceSlider{{ $mice->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        @endif
                                    </div>
                                @else
                                    <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="{{ $mice->name }}">
                                @endif
                                
                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title h3 mb-2" style="font-family: var(--heading-font);">{{ $mice->name }}</h5>
                                    <p class="mb-3 text-muted"><i class="fas fa-users me-2" style="color: #4682B4;"></i> Capacity: <strong>{{ $mice->capacity_theatre ?? $mice->capacity_classroom }}</strong></p>
                                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($mice->description, 100) }}</p>
                                    <a href="{{ route('mice.show', $mice->slug) }}" class="btn btn-custom mt-3 w-100">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- RESTAURANTS MARQUEE --}}
    @if(in_array('restaurants', $featuredOptions) && $featuredRestaurantImages->isNotEmpty())
        <section id="restaurants" class="featured-section alt-bg overflow-hidden">
            <div class="container mb-5">
                <div class="text-center">
                    <h2 class="section-title">Culinary Excellence</h2>
                    <p class="section-subtitle">Embark on a gastronomic journey with our world-class dining experiences, where every dish tells a story of passion, creativity, and the finest ingredients.</p>
                </div>
            </div>

            <div class="slider">
                <div class="slide-track">
                    @foreach($featuredRestaurantImages as $image)
                    <div class="slide">
                        @if($image->restaurant)
                        <a href="{{ route('restaurants.show', $image->restaurant->slug) }}">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->restaurant->name }}">
                        </a>
                        @endif
                    </div>
                    @endforeach

                    @foreach($featuredRestaurantImages as $image)
                    <div class="slide">
                        @if($image->restaurant)
                        <a href="{{ route('restaurants.show', $image->restaurant->slug) }}">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $image->restaurant->name }}">
                        </a>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
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