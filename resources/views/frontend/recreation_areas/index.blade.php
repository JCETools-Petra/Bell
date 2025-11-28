@extends('layouts.frontend')

 

@section('title', 'Recreation Areas')

 

@push('styles')
<style>
    /* Recreation Hero - Navy Professional Theme */
    .recreation-hero {
        position: relative;
        padding: 8rem 0 4rem;
        background: var(--color-primary);
        color: var(--color-white);
        text-align: center;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(30, 58, 138, 0.5);
    }

    .recreation-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.95) 0%, rgba(30, 58, 138, 0.85) 100%);
        z-index: 1;
    }

    .recreation-hero .container {
        position: relative;
        z-index: 2;
    }

    /* Custom Alert Styling */
    .alert-custom {
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.05) 0%, rgba(14, 165, 233, 0.05) 100%);
        border: 2px solid var(--color-secondary);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.1);
    }

    .alert-custom .icon-wrapper {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--color-primary), var(--color-secondary));
        border-radius: 50%;
        margin: 0 auto;
    }

    .alert-custom .icon {
        width: 40px;
        height: 40px;
        color: white;
    }

    .alert-custom .alert-heading {
        color: var(--color-primary);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .alert-custom p {
        color: #666;
        font-size: 1.1rem;
    }

    /* Recreation Card Styling */
    .recreation-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 0.5rem;
        background-color: #fff;
        overflow: hidden;
    }

    .recreation-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 60px rgba(30, 58, 138, 0.25) !important;
    }

    .recreation-card .card-img-container {
        overflow: hidden;
        height: 250px;
    }

    .recreation-card .card-img-top {
        transition: transform 0.3s ease;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recreation-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-title a {
        color: inherit;
        text-decoration: none;
    }

    .card-title a:hover {
        color: var(--color-secondary);
    }
</style>
@endpush

 

@section('content')

    {{-- Header Section - Updated to Navy Professional Theme --}}
    <div class="recreation-hero">
        <div class="container">
            <div class="page-title-content text-center text-white">
                <h1 class="display-3 fw-bold">Recreation Areas</h1>
                <p class="lead">Explore our facilities and enjoy your stay</p>
            </div>
        </div>
    </div>

    {{-- Recreation Areas List --}}
    <div class="page-content-wrapper py-5" style="background-color: #f8f9fa;">
        <div class="container">
            @if($recreationAreas->isEmpty())
                <div class="row">
                    <div class="col">
                        <div class="alert alert-custom text-center py-5">
                            <div class="icon-wrapper mb-4">
                                <svg class="icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="alert-heading">No Recreation Areas Available</h4>
                            <p>Information about our recreation areas is currently unavailable. Please check back later.</p>
                        </div>
                    </div>
                </div>
            @else

                <div class="row g-4">

                    @foreach($recreationAreas as $area)

                        <div class="col-md-6 col-lg-4 mb-4">

                            <div class="card h-100 shadow-sm recreation-card">

                                <a href="{{ route('recreation-areas.show', $area->slug) }}" class="card-img-container">

                                    @if ($area->images->isNotEmpty())

                                        <img src="{{ asset('storage/' . $area->images->first()->path) }}"

                                             class="card-img-top"

                                             alt="{{ $area->name }}">

                                    @else

                                        <img src="https://via.placeholder.com/400x250?text=No+Image"

                                             class="card-img-top"

                                             alt="No Image Available">

                                    @endif

                                </a>

                                <div class="card-body d-flex flex-column">

                                    <h5 class="card-title h4 mb-3">

                                        <a href="{{ route('recreation-areas.show', $area->slug) }}">{{ $area->name }}</a>

                                    </h5>

                                    <p class="card-text text-muted flex-grow-1">

                                        {{ Str::limit($area->description, 120) }}

                                    </p>

                                    <a href="{{ route('recreation-areas.show', $area->slug) }}"

                                       class="btn btn-outline-primary mt-3">

                                        View Details

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

@endsection