@extends('layouts.frontend')

@section('title', 'Our Restaurants')

@section('content')
<!-- Hero Section -->
<section class="restaurants-hero">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3 text-white" style="font-family: var(--heading-font); text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Our Restaurants</h1>
        <p class="lead mb-0 text-white mx-auto" style="max-width: 700px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            Discover culinary delights and unwind at our exquisite venues.
        </p>
    </div>
</section>

<!-- Restaurants List Section -->
<section class="featured-section">
    <div class="container">
        <div class="row g-5">
            @forelse($restaurants as $restaurant)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <!-- Image Slider -->
                        @if ($restaurant->images->isNotEmpty())
                            <div id="restaurantSlider{{ $restaurant->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                                <div class="carousel-inner">
                                    @foreach($restaurant->images as $image)
                                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100 card-img-top" alt="{{ $restaurant->name }}">
                                        </div>
                                    @endforeach
                                </div>
                                @if($restaurant->images->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#restaurantSlider{{ $restaurant->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#restaurantSlider{{ $restaurant->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <img src="https://via.placeholder.com/400x250" class="card-img-top" alt="{{ $restaurant->name }}">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-3">{{ $restaurant->name }}</h5>

                            <p class="card-text text-muted flex-grow-1" style="line-height: 1.7;">{{ Str::limit($restaurant->description, 140) }}</p>

                            <div class="mt-4 pt-3 border-top">
                                <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="btn btn-custom w-100 py-3">Discover Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No restaurants available.</h3>
                        <p class="text-muted">Please check back later.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if($restaurants->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $restaurants->links() }}
            </div>
        @endif
    </div>
</section>
@endsection