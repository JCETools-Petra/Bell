@extends('layouts.frontend')

@section('seo_title', $mice->seo_title ?: $mice->name)
@section('meta_description', $mice->meta_description ?: Str::limit(strip_tags($mice->description), 160))

@push('styles')
<style>
/* =================== PROFESSIONAL RESORT THEME =================== */
:root {
    --resort-primary: #87CEEB;
    --resort-secondary: #4682B4;
    --resort-dark: #1e3a5f;
    --resort-gold: #D4AF37;
    --resort-light: #f0f8ff;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background: #ffffff !important;
    font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    color: #333;
    line-height: 1.6;
}

.page-wrapper {
    width: 100%;
    overflow-x: hidden;
}

/* =================== BREADCRUMB =================== */
.breadcrumb-section {
    background: linear-gradient(135deg, var(--resort-light) 0%, #ffffff 100%);
    padding: 24px 0;
    border-bottom: 1px solid rgba(135, 206, 235, 0.2);
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.95rem;
    color: #666;
}

.breadcrumb-nav a {
    color: var(--resort-secondary);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-nav a:hover {
    color: var(--resort-primary);
}

.breadcrumb-separator {
    color: #999;
    font-size: 1.2rem;
}

/* =================== HERO SECTION =================== */
.mice-hero-section {
    padding: 60px 0;
    background: #ffffff;
}

.hero-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
}

.hero-grid {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 40px;
    align-items: start;
}

/* =================== IMAGE GALLERY =================== */
.mice-gallery {
    width: 100%;
}

.main-image-container {
    width: 100%;
    height: 600px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.15);
    position: relative;
    background: #f8f9fa;
}

#miceGalleryCarousel,
#miceGalleryCarousel .carousel-inner,
#miceGalleryCarousel .carousel-item {
    width: 100%;
    height: 100%;
}

#miceGalleryCarousel .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

/* Clean White Circular Controls */
.gallery-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.gallery-control:hover {
    background: #ffffff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    transform: translateY(-50%) scale(1.1);
}

.gallery-control.prev {
    left: 24px;
}

.gallery-control.next {
    right: 24px;
}

.gallery-control svg {
    width: 24px;
    height: 24px;
    stroke: var(--resort-dark);
    stroke-width: 2.5;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
}

/* Pill-Style Indicators */
.gallery-indicators {
    position: absolute;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 8px;
    z-index: 10;
}

.gallery-indicator {
    width: 8px;
    height: 8px;
    border-radius: 4px;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.gallery-indicator.active {
    width: 32px;
    background: #ffffff;
}

/* =================== INQUIRY CARD SIDEBAR =================== */
.inquiry-card {
    position: sticky;
    top: 120px;
    width: 420px;
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.15);
}

.inquiry-card-header {
    background: linear-gradient(135deg, var(--resort-dark) 0%, var(--resort-secondary) 100%);
    padding: 32px;
    color: #ffffff;
    text-align: center;
}

.inquiry-card-header h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0;
    letter-spacing: -0.5px;
}

.inquiry-card-header p {
    margin: 12px 0 0 0;
    font-size: 1rem;
    opacity: 0.9;
    line-height: 1.5;
}

.inquiry-card-body {
    padding: 32px;
}

.facilities-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--resort-dark);
    margin: 0 0 20px 0;
    letter-spacing: -0.3px;
}

.facilities-list {
    list-style: none;
    padding: 0;
    margin: 0 0 28px 0;
}

.facility-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    margin-bottom: 10px;
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.04), rgba(70, 130, 180, 0.04));
    border-radius: 12px;
    border-left: 3px solid var(--resort-primary);
    transition: all 0.3s ease;
}

.facility-item:hover {
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.1), rgba(70, 130, 180, 0.1));
    transform: translateX(4px);
}

.facility-icon {
    flex-shrink: 0;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--resort-primary), var(--resort-secondary));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.facility-icon svg {
    width: 20px;
    height: 20px;
    stroke: #ffffff;
    stroke-width: 3;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.facility-text {
    flex: 1;
    font-size: 0.95rem;
    color: #444;
    font-weight: 500;
}

/* Gold Gradient Button */
.btn-inquiry-resort {
    width: 100%;
    padding: 18px 24px;
    background: linear-gradient(135deg, var(--resort-gold) 0%, #B8860B 100%);
    color: #ffffff;
    border: none;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    position: relative;
    overflow: hidden;
}

.btn-inquiry-resort:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(212, 175, 55, 0.4);
}

.btn-inquiry-resort svg {
    width: 20px;
    height: 20px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
    stroke-linecap: round;
    stroke-linejoin: round;
}

/* =================== MICE INFO SECTION =================== */
.mice-info-section {
    padding: 60px 0;
    background: #ffffff;
}

.mice-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 24px;
}

.mice-header {
    text-align: center;
    margin-bottom: 60px;
}

.mice-title {
    font-size: 4rem;
    font-weight: 800;
    color: var(--resort-dark);
    margin: 0 0 20px 0;
    letter-spacing: -1.5px;
    line-height: 1.1;
}

.title-divider {
    width: 120px;
    height: 4px;
    background: linear-gradient(90deg, transparent, var(--resort-gold), transparent);
    margin: 0 auto 24px auto;
    border-radius: 2px;
}

.mice-subtitle {
    font-size: 1.25rem;
    color: #666;
    margin: 0;
    font-weight: 400;
}

/* Specifications Grid */
.specs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 24px;
    margin: 40px 0;
    padding: 40px;
    background: linear-gradient(135deg, var(--resort-light) 0%, #ffffff 100%);
    border-radius: 20px;
    border: 2px solid rgba(135, 206, 235, 0.3);
}

.spec-item {
    text-align: center;
    padding: 20px;
}

.spec-label {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--resort-secondary);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.spec-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--resort-dark);
}

/* Description */
.mice-description {
    font-size: 1.15rem;
    line-height: 1.9;
    color: #555;
    text-align: justify;
    margin: 40px 0;
}

/* =================== LAYOUT CAPACITY SECTION =================== */
.capacity-section {
    padding: 80px 0;
    background: linear-gradient(135deg, var(--resort-light) 0%, #ffffff 100%);
}

.section-title {
    font-size: 3rem;
    font-weight: 800;
    color: var(--resort-dark);
    text-align: center;
    margin: 0 0 20px 0;
    letter-spacing: -1px;
}

.section-divider {
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, transparent, var(--resort-gold), transparent);
    margin: 0 auto 60px auto;
    border-radius: 2px;
}

.capacity-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 28px;
    max-width: 1200px;
    margin: 0 auto;
}

.capacity-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 36px 24px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(30, 58, 95, 0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid rgba(135, 206, 235, 0.1);
}

.capacity-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.15);
    border-color: var(--resort-primary);
}

.capacity-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 20px auto;
    object-fit: cover; /* Changed to cover for user uploaded images */
    border-radius: 10px; /* Added radius for user images */
}

.capacity-name {
    font-size: 1rem;
    font-weight: 700;
    color: var(--resort-dark);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    margin-top: 15px;
}

.capacity-value {
    font-size: 2rem;
    font-weight: 800;
    background: linear-gradient(135deg, var(--resort-gold), #B8860B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* =================== INQUIRY MODAL =================== */
.modal-content {
    border-radius: 20px;
    border: none;
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, var(--resort-dark) 0%, var(--resort-secondary) 100%);
    color: #ffffff;
    padding: 28px 32px;
    border: none;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
}

.btn-close {
    filter: invert(1);
}

.modal-body {
    padding: 32px;
}

.form-label {
    font-weight: 600;
    color: var(--resort-dark);
    margin-bottom: 8px;
}

.form-control,
.form-select {
    border: 2px solid rgba(135, 206, 235, 0.3);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: var(--resort-primary);
    box-shadow: 0 0 0 4px rgba(135, 206, 235, 0.1);
}

/* =================== RESPONSIVE =================== */
@media (max-width: 991.98px) {
    .hero-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .inquiry-card {
        position: static;
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
    }

    .main-image-container {
        height: 450px;
    }

    .mice-title {
        font-size: 3rem;
    }

    .section-title {
        font-size: 2.5rem;
    }

    .capacity-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .specs-grid {
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        padding: 28px;
    }
}

@media (max-width: 767.98px) {
    .hero-container,
    .mice-container {
        padding: 0 16px;
    }

    .mice-hero-section,
    .mice-info-section {
        padding: 40px 0;
    }

    .capacity-section {
        padding: 60px 0;
    }

    .main-image-container {
        height: 380px;
        border-radius: 16px;
    }

    .gallery-control {
        width: 44px;
        height: 44px;
    }

    .gallery-control.prev {
        left: 16px;
    }

    .gallery-control.next {
        right: 16px;
    }

    .mice-title {
        font-size: 2.5rem;
    }

    .section-title {
        font-size: 2rem;
    }

    .capacity-grid {
        grid-template-columns: 1fr;
    }

    .specs-grid {
        grid-template-columns: 1fr;
    }

    .inquiry-card-header,
    .inquiry-card-body {
        padding: 24px;
    }
}

/* Placeholder */
.placeholder-hero {
    width: 100%;
    height: 600px;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    color: #6c757d;
}

.placeholder-hero h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 12px;
}

.placeholder-hero p {
    font-size: 1.1rem;
    opacity: 0.7;
}

@media (max-width: 767.98px) {
    .placeholder-hero {
        height: 380px;
    }

    .placeholder-hero h2 {
        font-size: 1.5rem;
    }

    .placeholder-hero p {
        font-size: 1rem;
    }
}
</style>
@endpush

@section('content')
<div class="page-wrapper">

  {{-- =================== BREADCRUMB =================== --}}
  <section class="breadcrumb-section">
    <div class="hero-container">
      <nav class="breadcrumb-nav">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-separator">›</span>
        <a href="{{ route('mice.index') }}">MICE</a>
        <span class="breadcrumb-separator">›</span>
        <span>{{ $mice->name }}</span>
      </nav>
    </div>
  </section>

  {{-- =================== HERO SECTION WITH GRID =================== --}}
  <section class="mice-hero-section">
    <div class="hero-container">
      <div class="hero-grid">

        {{-- IMAGE GALLERY --}}
        <div class="mice-gallery">
          @if($mice->images->isNotEmpty())
            <div class="main-image-container">
              <div id="miceGalleryCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                <div class="carousel-inner">
                  @foreach($mice->images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                      {{-- Fix Image Path --}}
                      <img src="{{ Str::contains($image->path, 'storage/') ? asset($image->path) : asset('storage/' . str_replace('public/', '', $image->path)) }}"
                           alt="Photo of {{ $mice->name }}"
                           @if(!$loop->first) loading="lazy" @endif
                           onerror="this.onerror=null;this.src='https://via.placeholder.com/1200x800?text=No+Image';">
                    </div>
                  @endforeach
                </div>

                {{-- Clean White Circular Controls --}}
                <button class="gallery-control prev" type="button" data-bs-target="#miceGalleryCarousel" data-bs-slide="prev" aria-label="Previous">
                  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button class="gallery-control next" type="button" data-bs-target="#miceGalleryCarousel" data-bs-slide="next" aria-label="Next">
                  <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>

                {{-- Pill-Style Indicators --}}
                <div class="gallery-indicators">
                  @foreach($mice->images as $key => $image)
                    <button type="button"
                            class="gallery-indicator {{ $loop->first ? 'active' : '' }}"
                            data-bs-target="#miceGalleryCarousel"
                            data-bs-slide-to="{{ $key }}"
                            aria-label="Slide {{ $key + 1 }}"></button>
                  @endforeach
                </div>
              </div>
            </div>
          @else
            <div class="placeholder-hero">
              <h2>{{ $mice->name }}</h2>
              <p>No images available yet</p>
            </div>
          @endif
        </div>

        {{-- INQUIRY CARD SIDEBAR --}}
        <div class="inquiry-card">
          <div class="inquiry-card-header">
            <h3>Inquiry & Booking</h3>
            <p>Flexible pricing for your event needs</p>
          </div>

          <div class="inquiry-card-body">
            <h3 class="facilities-title">Premium Facilities</h3>
            <ul class="facilities-list">
              @foreach(explode("\n", $mice->facilities) as $facility)
                @if(trim($facility) != '')
                  <li class="facility-item">
                    <div class="facility-icon">
                      <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </div>
                    <span class="facility-text">{{ trim($facility) }}</span>
                  </li>
                @endif
              @endforeach
            </ul>

            <button type="button" class="btn-inquiry-resort" data-bs-toggle="modal" data-bs-target="#inquiryModal">
              <svg viewBox="0 0 24 24">
                <path d="M21 10H3M16 2v4M8 2v4M7.8 22h8.4c1.68 0 2.52 0 3.162-.327a3 3 0 0 0 1.311-1.311C21 19.72 21 18.88 21 17.2V8.8c0-1.68 0-2.52-.327-3.162a3 3 0 0 0-1.311-1.311C18.72 4 17.88 4 16.2 4H7.8c-1.68 0-2.52 0-3.162.327a3 3 0 0 0-1.311 1.311C3 6.28 3 7.12 3 8.8v8.4c0 1.68 0 2.52.327 3.162a3 3 0 0 0 1.311 1.311C5.28 22 6.12 22 7.8 22Z"></path>
              </svg>
              Contact Sales
            </button>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- =================== MICE INFO SECTION =================== --}}
  <section class="mice-info-section">
    <div class="mice-container">
      <div class="mice-header">
        <h1 class="mice-title">{{ $mice->name }}</h1>
        <div class="title-divider"></div>
        <p class="mice-subtitle">Perfect venue for your meetings, events, and celebrations</p>
      </div>

      {{-- SPECIFICATIONS GRID (Dimension, Size, Capacity Overall) --}}
      @if($mice->dimension || $mice->size_sqm || $mice->capacity || $mice->capacity_theatre || $mice->capacity_classroom || $mice->capacity_ushape || $mice->capacity_round || $mice->capacity_board)
        <div class="specs-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
          @if($mice->dimension)
            <div class="spec-item">
              <div class="spec-label">Dimension</div>
              <div class="spec-value">{{ $mice->dimension }}</div>
            </div>
          @endif
          @if($mice->size_sqm)
            <div class="spec-item">
              <div class="spec-label">Size</div>
              <div class="spec-value">{{ $mice->size_sqm }}</div>
            </div>
          @endif
          @if($mice->capacity)
            <div class="spec-item">
              <div class="spec-label">Total Capacity</div>
              <div class="spec-value">{{ $mice->capacity }} Pax</div>
            </div>
          @endif
          @if($mice->capacity_theatre)
            <div class="spec-item">
              <div class="spec-label">Theatre Setup</div>
              <div class="spec-value">{{ $mice->capacity_theatre }} Pax</div>
            </div>
          @endif
          @if($mice->capacity_classroom)
            <div class="spec-item">
              <div class="spec-label">Classroom Setup</div>
              <div class="spec-value">{{ $mice->capacity_classroom }} Pax</div>
            </div>
          @endif
          @if($mice->capacity_ushape)
            <div class="spec-item">
              <div class="spec-label">U-Shape Setup</div>
              <div class="spec-value">{{ $mice->capacity_ushape }} Pax</div>
            </div>
          @endif
          @if($mice->capacity_round)
            <div class="spec-item">
              <div class="spec-label">Round Table Setup</div>
              <div class="spec-value">{{ $mice->capacity_round }} Pax</div>
            </div>
          @endif
          @if($mice->capacity_board)
            <div class="spec-item">
              <div class="spec-label">Boardroom Setup</div>
              <div class="spec-value">{{ $mice->capacity_board }} Pax</div>
            </div>
          @endif
        </div>
      @endif

      {{-- DESCRIPTION --}}
      <div class="mice-description">
        {!! nl2br(e($mice->description)) !!}
      </div>
    </div>
  </section>

  {{-- =================== LAYOUT CAPACITY SECTION =================== --}}
  @php
    $layouts = [];
    $rawSpecs = $mice->specifications;

    // LOGIKA PENGECEKAN YANG LEBIH KUAT
    if (!empty($rawSpecs)) {
        // 1. Jika database/model sudah otomatis mengubahnya jadi Array
        if (is_array($rawSpecs)) {
            $layouts = $rawSpecs;
        } 
        // 2. Jika masih berupa String JSON
        elseif (is_string($rawSpecs)) {
            $decoded = json_decode($rawSpecs, true);
            if (is_array($decoded)) {
                $layouts = $decoded;
            }
        }
    }
  @endphp

  @if(count($layouts) > 0)
    <section class="capacity-section">
      <div class="mice-container">
        <h2 class="section-title">Layout Configuration</h2>
        <div class="section-divider"></div>

        <div class="capacity-grid">
          @foreach($layouts as $layout)
            {{-- Pastikan item memiliki key dan value sebelum ditampilkan --}}
            @if(isset($layout['key']) && !empty($layout['value']))
                <div class="capacity-card">
                    @if(!empty($layout['image']))
                      @php
                          $iconPath = $layout['image'];
                      @endphp
                      <img src="{{ Str::contains($iconPath, 'storage/') ? asset($iconPath) : asset('storage/' . str_replace('public/', '', $iconPath)) }}"
                           alt="{{ $layout['key'] }} Layout"
                           class="capacity-icon"
                           onerror="this.onerror=null;this.src='https://via.placeholder.com/100?text={{ substr($layout['key'], 0, 1) }}';">
                    @else
                       {{-- Fallback Icon jika tidak ada gambar --}}
                       <div class="capacity-icon d-flex align-items-center justify-content-center bg-light rounded-circle mb-3" style="width: 100px; height: 100px; margin: 0 auto;">
                            <span class="fs-1 fw-bold text-muted">{{ substr($layout['key'], 0, 1) }}</span>
                       </div>
                    @endif
                    <div class="capacity-name">{{ $layout['key'] }}</div>
                    <div class="capacity-value">{{ $layout['value'] }}</div>
                </div>
            @endif
          @endforeach
        </div>
      </div>
    </section>
  @endif

</div>

{{-- =================== INQUIRY MODAL =================== --}}
<div class="modal fade" id="inquiryModal" tabindex="-1" aria-labelledby="inquiryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="inquiryModalLabel">Inquiry for {{ $mice->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('mice.inquiries.store') }}" method="POST" id="inquiryForm">
          @csrf
          <input type="hidden" name="mice_room_id" value="{{ $mice->id }}">

          <div class="mb-3">
            <label for="customer_name" class="form-label">Your Name</label>
            <input type="text" class="form-control" id="customer_name" name="customer_name" required>
          </div>

          <div class="mb-3">
            <label for="customer_phone" class="form-label">WhatsApp Number (Example: 08123456789)</label>
            <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required pattern="^08[0-9]{8,11}$">
          </div>

          <div class="mb-3">
            <label for="event_type" class="form-label">Event Type</label>
            <select class="form-select" id="event_type" name="event_type" required>
              <option value="">-- Select Event Type --</option>
              <option value="meeting">Meeting</option>
              <option value="wedding">Wedding</option>
              <option value="birthday">Birthday Party</option>
              <option value="seminar">Seminar</option>
              <option value="other">Other</option>
            </select>
          </div>

          <div class="mb-3" id="other-event-wrapper" style="display: none;">
            <label for="event_other_description" class="form-label">Specify Other Event Type</label>
            <input type="text" class="form-control" id="event_other_description" name="event_other_description">
          </div>

          <div class="d-grid">
            <button type="submit" class="btn-inquiry-resort">Send Inquiry</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.getElementById('event_type').addEventListener('change', function () {
    var wrapper = document.getElementById('other-event-wrapper');
    var otherInput = document.getElementById('event_other_description');
    if (this.value === 'other') {
      wrapper.style.display = 'block';
      otherInput.required = true;
    } else {
      wrapper.style.display = 'none';
      otherInput.required = false;
    }
  });
</script>
@endpush
@endsection