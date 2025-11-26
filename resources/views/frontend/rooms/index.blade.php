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
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4">
            @forelse($rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
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

                        <div class="card-body d-flex flex-column p-4">
                            <div class="mb-2">
                                <h5 class="card-title h3 mb-1" style="font-family: var(--heading-font);">{{ $room->name }}</h5>
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="fas fa-user-friends me-2"></i> {{ $room->capacity ?? 2 }} Guests
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-ruler-combined me-2"></i> {{ $room->size ?? '20' }} m²
                                </div>
                            </div>
                            
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($room->description, 100) }}</p>
                            
                            <div class="d-flex justify-content-between align-items-end mt-3">
                                <div>
                                    <small class="text-muted d-block">Starts from</small>
                                    <span class="h4 fw-bold mb-0" style="background: linear-gradient(135deg, #87CEEB, #8FBC8F); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">Rp {{ number_format($room->price, 0, ',', '.') }}</span>
                                    <small class="text-muted">/ night</small>
                                </div>
                                <a href="{{ route('rooms.show', $room->slug) }}" class="btn rounded-pill px-4" style="background: linear-gradient(135deg, #87CEEB, #8FBC8F); color: white; border: none;">View Details</a>
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