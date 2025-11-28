@extends('layouts.frontend')

@section('title', $restaurant->name)

@section('content')
<!-- Hero Section -->
<section class="restaurant-detail-hero">
    @if($restaurant->images->isNotEmpty())
        <img src="{{ asset('storage/' . $restaurant->images->first()->path) }}" alt="{{ $restaurant->name }}" class="restaurant-detail-hero-bg">
    @else
        <div class="restaurant-detail-hero-bg" style="background-color: #333;"></div>
    @endif
    
    <div class="container">
        <h1 class="display-3 fw-bold mb-3 text-gold" style="font-family: var(--heading-font);">{{ $restaurant->name }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('restaurants.index') }}" class="text-white text-decoration-none">Restaurants</a></li>
                <li class="breadcrumb-item active text-white-50" aria-current="page">{{ $restaurant->name }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Content Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 class="section-title mb-4">About The Venue</h2>
                    <div class="lead text-muted" style="line-height: 1.8;">
                        {!! $restaurant->description !!}
                    </div>
                </div>
            </div>
        </div>

        @if($restaurant->images->count() > 1)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="text-center mb-4" style="font-family: var(--heading-font);">Gallery</h3>
                    <div class="gallery-grid">
                        @foreach($restaurant->images->skip(1) as $image)
                            <div class="gallery-item">
                                <a href="{{ asset('storage/' . $image->path) }}" data-lightbox="restaurant-gallery" data-title="{{ $restaurant->name }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $restaurant->name }}" loading="lazy">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
@endpush