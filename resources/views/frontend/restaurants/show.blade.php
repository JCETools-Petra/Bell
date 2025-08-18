@extends('layouts.frontend')

@section('seo_title', $restaurant->name)
@section('meta_description', Str::limit(strip_tags($restaurant->description), 160))

@section('content')
<style>
    .carousel-item img {
        height: 550px;
        object-fit: cover;
    }
</style>

<div class="page-content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                
                <h1 class="display-4 text-center">{{ $restaurant->name }}</h1>
                <hr class="mx-auto" style="border-color: var(--color-gold); border-width: 2px; width: 100px; opacity: 1;">

                @if($restaurant->images->isNotEmpty())
                    <div id="restaurantCarousel" class="carousel slide shadow-lg rounded overflow-hidden my-5" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach($restaurant->images as $key => $image)
                                <button type="button" data-bs-target="#restaurantCarousel" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($restaurant->images as $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100" alt="{{ $restaurant->name }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#restaurantCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#restaurantCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @endif

                <div class="lead mt-4" style="text-align: justify;">
                    {!! nl2br(e($restaurant->description)) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection