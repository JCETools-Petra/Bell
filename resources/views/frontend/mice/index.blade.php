@extends('layouts.frontend')

@section('title', 'MICE & Events')

@section('content')
<!-- Hero Section -->
<section class="mice-hero">
    <div class="container">
        <h1 class="display-4 fw-bold mb-3 text-white" style="font-family: var(--heading-font); text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">MICE & Events</h1>
        <p class="lead mb-0 text-white mx-auto" style="max-width: 700px; text-shadow: 1px 1px 2px rgba(0,0,0,0.3);">
            Meetings, Incentives, Conferences, and Exhibitions. The perfect venues for your professional gatherings.
        </p>
    </div>
</section>

<!-- MICE List Section -->
<section class="featured-section">
    <div class="container">
        <div class="row g-5">
            @forelse($miceRooms as $mice)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <!-- Image Slider -->
                        @if ($mice->images->isNotEmpty())
                            <div id="miceSlider{{ $mice->id }}" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
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

                        <div class="card-body d-flex flex-column">
                            <div class="mb-3">
                                <h5 class="card-title mb-3">{{ $mice->name }}</h5>
                                <div class="p-3 rounded" style="background: linear-gradient(135deg, rgba(135, 206, 235, 0.15), rgba(70, 130, 180, 0.15));">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-users fs-4 me-3" style="color: #4682B4;"></i>
                                        <div>
                                            <small class="text-muted d-block" style="font-size: 0.85rem;">Maximum Capacity</small>
                                            <strong class="text-primary fs-5">{{ $mice->capacity_theatre ?? $mice->capacity_classroom }}</strong>
                                            <small class="text-muted"> persons</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <p class="card-text text-muted flex-grow-1" style="line-height: 1.7;">{{ Str::limit($mice->description, 130) }}</p>

                            <div class="mt-4">
                                <a href="{{ route('mice.show', $mice->slug) }}" class="btn btn-custom w-100 py-3">Explore Venue</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="py-5">
                        <i class="fas fa-building fa-3x text-muted mb-3"></i>
                        <h3 class="text-muted">No MICE venues available.</h3>
                        <p class="text-muted">Please contact us for more information.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $miceRooms->links() }}
        </div>
    </div>
</section>
@endsection