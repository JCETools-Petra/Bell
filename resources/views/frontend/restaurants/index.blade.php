@extends('layouts.frontend')

@section('title', 'Our Restaurants')

@section('content')
<div class="page-content-wrapper">
    <div class="container">
        <h1 class="section-title text-center mb-5">Our Restaurants</h1>
        <div class="row">
            @forelse($restaurants as $restaurant)
                <div class="col-md-6 col-lg-4 mb-4">
                        <a href="{{ route('restaurants.show', $restaurant->slug) }}" class="text-decoration-none text-dark d-block h-100">
                            <div class="card h-100 shadow-sm border-0">
                                @if ($restaurant->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $restaurant->images->first()->path) }}" class="card-img-top" alt="{{ $restaurant->name }}">
                                @else
                                    <img src="https://via.placeholder.com/400x250?text=No+Image" class="card-img-top" alt="No Image Available">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title h4">{{ $restaurant->name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($restaurant->description, 120) }}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col">
                    <p class="text-center fs-4">No restaurants available at the moment.</p>
                </div>
            @endforelse
        </div>
        @if($restaurants->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $restaurants->links() }}
            </div>
        @endif
    </div>
</div>
@endsection