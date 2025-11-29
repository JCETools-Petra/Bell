@extends('layouts.frontend')

@section('title', $recreationArea->name)

@push('styles')
<style>
    /* Modern Recreation Area Detail Page */
    .recreation-detail-page {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
        min-height: 100vh;
    }

    /* Hero Slider - Full Width Modern Design */
    .recreation-hero-section {
        position: relative;
        height: 85vh;
        min-height: 600px;
        max-height: 800px;
        overflow: hidden;
        background: #000;
    }

    .recreation-hero-carousel .carousel-item {
        height: 85vh;
        min-height: 600px;
        max-height: 800px;
    }

    .recreation-hero-carousel .carousel-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(30, 58, 138, 0.95) 100%);
        padding: 4rem 0 2rem;
        z-index: 10;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        color: white;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        margin-bottom: 1rem;
    }

    .hero-location {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Carousel Controls */
    .recreation-hero-carousel .carousel-control-prev,
    .recreation-hero-carousel .carousel-control-next {
        width: 60px;
        height: 60px;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(30, 58, 138, 0.7);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        opacity: 0.8;
        transition: all 0.3s ease;
    }

    .recreation-hero-carousel .carousel-control-prev {
        left: 2rem;
    }

    .recreation-hero-carousel .carousel-control-next {
        right: 2rem;
    }

    .recreation-hero-carousel .carousel-control-prev:hover,
    .recreation-hero-carousel .carousel-control-next:hover {
        opacity: 1;
        background: rgba(30, 58, 138, 0.9);
        transform: translateY(-50%) scale(1.1);
    }

    .recreation-hero-carousel .carousel-indicators {
        bottom: 2rem;
        gap: 0.5rem;
    }

    .recreation-hero-carousel .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        border: 2px solid white;
        transition: all 0.3s ease;
    }

    .recreation-hero-carousel .carousel-indicators button.active {
        width: 40px;
        border-radius: 6px;
        background: white;
    }

    /* Description Section */
    .description-card {
        background: white;
        border-radius: 24px;
        padding: 3rem;
        box-shadow: 0 10px 40px rgba(30, 58, 138, 0.08);
        margin-top: -100px;
        position: relative;
        z-index: 20;
    }

    .description-text {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #555;
    }

    /* Photo Gallery - Modern Grid */
    .modern-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .gallery-card {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .gallery-card::before {
        content: '';
        display: block;
        padding-bottom: 75%;
    }

    .gallery-card img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .gallery-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 16px 48px rgba(30, 58, 138, 0.2);
    }

    .gallery-card:hover img {
        transform: scale(1.1);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(30, 58, 138, 0.7) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-zoom-icon {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .gallery-card:hover .gallery-zoom-icon {
        transform: scale(1);
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .modern-gallery {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
        }

        .description-card {
            padding: 2rem;
            margin-top: -60px;
        }

        .recreation-hero-carousel .carousel-control-prev,
        .recreation-hero-carousel .carousel-control-next {
            width: 50px;
            height: 50px;
        }
    }
</style>
@endpush

@section('content')
<div class="recreation-detail-page">

    {{-- Hero Slider Section --}}
    <section class="recreation-hero-section">
        @if($recreationArea->images->isNotEmpty())
            <div id="recreationHeroCarousel" class="carousel slide recreation-hero-carousel h-100" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner h-100">
                    @foreach($recreationArea->images->take(5) as $image)
                        <div class="carousel-item h-100 {{ $loop->first ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->path) }}"
                                 alt="{{ $image->caption ?? $recreationArea->name }}"
                                 @if(!$loop->first) loading="lazy" @endif>
                        </div>
                    @endforeach
                </div>

                @if($recreationArea->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#recreationHeroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#recreationHeroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <div class="carousel-indicators">
                        @foreach($recreationArea->images->take(5) as $key => $image)
                            <button type="button"
                                    data-bs-target="#recreationHeroCarousel"
                                    data-bs-slide-to="{{ $key }}"
                                    class="{{ $loop->first ? 'active' : '' }}"
                                    aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="hero-overlay">
                <div class="container">
                    <h1 class="hero-title">{{ $recreationArea->name }}</h1>
                    @if($recreationArea->location)
                        <div class="hero-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{ $recreationArea->location }}</span>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="d-flex align-items-center justify-content-center h-100" style="background: linear-gradient(135deg, #1e3a8a 0%, #0ea5e9 100%);">
                <div class="text-center text-white">
                    <h1 class="display-3 mb-3">{{ $recreationArea->name }}</h1>
                    <p class="lead">No images available yet.</p>
                </div>
            </div>
        @endif
    </section>

    {{-- Description Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-11">
                    <div class="description-card">
                        <div class="text-center mb-4">
                            <span class="badge bg-admin-tertiary text-white px-4 py-2 rounded-pill mb-3" style="font-size: 0.9rem; letter-spacing: 1px;">ABOUT</span>
                            <h2 class="fw-bold mb-4" style="font-size: 2.2rem; color: #1e3a8a;">Discover {{ $recreationArea->name }}</h2>
                        </div>

                        @if($recreationArea->description)
                            <div class="description-text">
                                {!! nl2br(e($recreationArea->description)) !!}
                            </div>
                        @else
                            <p class="text-center text-muted">No description available.</p>
                        @endif

                        <div class="row g-3 mt-5">
                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #06b6d4;">
                                        <i class="fas fa-clock text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Opening Hours</div>
                                        <div class="fw-bold text-admin-primary">Open Daily</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #fbbf24;">
                                        <i class="fas fa-users text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Access</div>
                                        <div class="fw-bold" style="color: #92400e;">Hotel Guests</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: #10b981;">
                                        <i class="fas fa-check-circle text-white fs-5"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted">Facilities</div>
                                        <div class="fw-bold text-success">Complete</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Photo Gallery Section - Show ALL Images --}}
    @if($recreationArea->images->isNotEmpty())
        <section class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="badge bg-admin-accent text-dark px-4 py-2 rounded-pill mb-3" style="font-size: 0.9rem; letter-spacing: 1px;">GALLERY</span>
                    <h2 class="fw-bold mb-3" style="font-size: 2.2rem; color: #1e3a8a;">Photo Gallery</h2>
                    <p class="text-muted" style="font-size: 1.1rem;">Explore our recreation area through these stunning images</p>
                </div>

                <div class="modern-gallery">
                    @foreach($recreationArea->images as $image)
                        <div class="gallery-card">
                            <a href="{{ asset('storage/' . $image->path) }}"
                               data-lightbox="recreation-gallery"
                               data-title="{{ $image->caption ?? $recreationArea->name }}">
                                <img src="{{ asset('storage/' . $image->path) }}"
                                     alt="{{ $image->caption ?? $recreationArea->name }}"
                                     loading="lazy">
                                <div class="gallery-overlay">
                                    <div class="gallery-zoom-icon">
                                        <i class="fas fa-search-plus fs-4 text-admin-primary"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Back Button --}}
    <section class="py-5">
        <div class="container">
            <div class="text-center">
                <a href="{{ route('recreation-areas.index') }}"
                   class="btn btn-outline-admin-primary btn-lg rounded-pill px-5"
                   style="font-weight: 600; border-width: 2px;">
                    <i class="fas fa-arrow-left me-2"></i> Back to Recreation Areas
                </a>
            </div>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script>
    // Configure Lightbox
    lightbox.option({
        'resizeDuration': 200,
        'wrapAround': true,
        'albumLabel': 'Image %1 of %2',
        'fadeDuration': 300,
        'imageFadeDuration': 300
    });
</script>
@endpush
