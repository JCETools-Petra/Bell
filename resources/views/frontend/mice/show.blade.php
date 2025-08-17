@section('seo_title', $mice->seo_title ?: $mice->name)
@section('meta_description', $mice->meta_description ?: Str::limit(strip_tags($mice->description), 160))
@extends('layouts.frontend')

@section('title', $mice->name)

@section('content')
<div class="page-content-wrapper">
    <div class="container">
    <div class="row">
        <div class="col-lg-8">
            @if($mice->images->isNotEmpty())
                <div id="miceCarousel" class="carousel slide shadow-lg rounded overflow-hidden mb-4" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        @foreach($mice->images as $key => $image)
                            <button type="button" data-bs-target="#miceCarousel" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>
                    <div class="carousel-inner">
                        @foreach($mice->images as $image)
                            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $mice->name }}">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#miceCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#miceCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            @else
                <img src="https://via.placeholder.com/800x500?text=No+Image+Available" class="img-fluid rounded shadow-lg mb-4" alt="No Image Available">
            @endif

            <h1 class="display-4">{{ $mice->name }}</h1>
            <hr style="border-color: var(--color-gold); border-width: 2px; width: 100px; opacity: 1;">
            
            <div class="my-4">
                <div class="row border-top border-bottom py-3">
                    @if($mice->dimension)
                    <div class="col-6 col-md-3">
                        <strong>DIMENSION</strong>
                        <p class="h5">{{ $mice->dimension }}</p>
                    </div>
                    @endif
                    @if($mice->size_sqm)
                    <div class="col-6 col-md-3">
                        <strong>SIZE</strong>
                        <p class="h5">{{ $mice->size_sqm }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <p class="lead mt-4" style="text-align: justify;">
                {!! nl2br(e($mice->description)) !!}
            </p>

            <div class="my-5">
                <h2 class="section-title text-center mb-5">Layout Capacity</h2>
                <div class="row text-center g-4 justify-content-center">
                    @php
                        // Cocokkan nama layout dengan key di database
                        $layouts = [
                            'Classroom' => ['capacity' => $mice->capacity_classroom, 'icon_key' => 'layout_icon_classroom'],
                            'Theatre' => ['capacity' => $mice->capacity_theatre, 'icon_key' => 'layout_icon_theatre'],
                            'U-Shape' => ['capacity' => $mice->capacity_ushape, 'icon_key' => 'layout_icon_ushape'],
                            'Round Table' => ['capacity' => $mice->capacity_round, 'icon_key' => 'layout_icon_round'],
                            'Board Room' => ['capacity' => $mice->capacity_board, 'icon_key' => 'layout_icon_board'],
                        ];
                    @endphp

                    @foreach($layouts as $name => $details)
                        @if($details['capacity'])
                        <div class="col-6 col-md-4 col-lg-3 mb-3">
                            <div class="card card-body text-center h-100 justify-content-center">
                                @if(isset($settings[$details['icon_key']]))
                                    <img src="{{ asset('storage/' . $settings[$details['icon_key']]) }}" class="mb-2 mx-auto" style="width: 80px; height: 80px; object-fit: contain;">
                                @endif
                                <h6 class="fw-bold text-uppercase small">{{ $name }}</h6>
                                <span class="h5 fw-bold" style="color: var(--color-gold);">{{ $details['capacity'] }} Pax</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 110px;">
                <div class="card-body">
                    <h4 class="card-title h2">Inquiry & Booking</h4>
                    <hr>
                    <p class="mb-4">
                        Harga untuk event dan meeting bersifat fleksibel. Silakan hubungi tim sales kami untuk mendapatkan penawaran terbaik sesuai kebutuhan Anda.
                    </p>
                    
                    <h5 class="mt-4">Fasilitas Unggulan</h5>
                    <ul class="list-unstyled">
                        @foreach(explode("\n", $mice->facilities) as $facility)
                            @if(trim($facility) != '')
                                <li class="mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill d-inline-block me-2" style="color: var(--color-gold);" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                    </svg>
                                    {{ trim($facility) }}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <a href="#" class="btn btn-custom w-100 mt-3">Hubungi Sales</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection