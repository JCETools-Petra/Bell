@extends('layouts.frontend')

@section('title', 'Our Rooms')

@section('content')
<!-- Hero Section -->
<section class="rooms-hero">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3 text-white" style="font-family: var(--heading-font); text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Our Rooms</h1>
        <p class="lead mb-0 text-white mx-auto" style="max-width: 600px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            Experience comfort and elegance in our thoughtfully designed rooms.
        </p>
    </div>
</section>

<!-- Rooms List Section -->
<section class="featured-section">
    <div class="container">
        <div class="row g-5">
            @forelse($rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <!-- Image Slider -->
                        @if ($room->images->isNotEmpty())
                            <div id="roomSlider{{ $room->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
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

                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <h5 class="card-title mb-2">{{ $room->name }}</h5>
                                <div class="d-flex align-items-center gap-3 text-muted small">
                                    <span><i class="fas fa-user-friends me-1" style="color: var(--color-accent);"></i> {{ $room->capacity ?? 2 }} Guests</span>
                                    <span><i class="fas fa-ruler-combined me-1" style="color: var(--color-accent);"></i> {{ $room->size ?? '20' }} m²</span>
                                </div>
                            </div>

                            <p class="card-text text-muted flex-grow-1" style="line-height: 1.7;">{{ Str::limit($room->description, 120) }}</p>

                            <div class="mt-4 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted d-block mb-1" style="font-size: 0.85rem;">Starting from</small>
                                        <div class="h4 fw-bold mb-0" style="background: linear-gradient(135deg, #87CEEB, #4682B4); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                                            Rp {{ number_format($room->price, 0, ',', '.') }}
                                            <small class="text-muted" style="font-size: 0.8rem; font-weight: 400;">/ night</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('rooms.show', $room->slug) }}" class="btn btn-custom px-4 py-2">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No rooms available at the moment.</h3>
                        <p class="text-muted">Please check back later.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $rooms->links() }}
        </div>
    </div>
</section>
@endsection