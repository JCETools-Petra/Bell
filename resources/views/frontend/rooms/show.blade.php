@extends('layouts.frontend')

@section('seo_title', $room->seo_title ?: $room->name)
@section('meta_description', $room->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($room->description), 160))

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
/* =============== PROFESSIONAL RESORT THEME =============== */
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
    color: #2c3e50;
    line-height: 1.6;
}

.page-wrapper {
    width: 100%;
    background: linear-gradient(180deg, #f8fcff 0%, #ffffff 50%);
}

/* =============== BREADCRUMB SECTION =============== */
.breadcrumb-section {
    background: white;
    padding: 20px 0;
    border-bottom: 1px solid #e8f4f8;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.9rem;
    color: #64748b;
}

.breadcrumb-nav a {
    color: var(--resort-secondary);
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb-nav a:hover {
    color: var(--resort-primary);
}

.breadcrumb-separator {
    color: #cbd5e1;
}

/* =============== HERO SECTION =============== */
.room-hero-section {
    padding: 60px 0;
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

/* =============== IMAGE GALLERY =============== */
.room-gallery {
    position: relative;
}

.main-image-container {
    width: 100%;
    height: 600px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 50px rgba(30, 58, 95, 0.12);
    position: relative;
    background: #f8f9fa;
}

.carousel {
    width: 100%;
    height: 100%;
}

.carousel-inner,
.carousel-item {
    width: 100%;
    height: 100%;
}

.carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
}

/* Modern Gallery Controls */
.gallery-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.95);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    z-index: 10;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.gallery-control:hover {
    background: white;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    transform: translateY(-50%) scale(1.05);
}

.gallery-control.prev { left: 20px; }
.gallery-control.next { right: 20px; }

.gallery-control svg {
    width: 24px;
    height: 24px;
    stroke: var(--resort-dark);
    stroke-width: 2.5;
    fill: none;
}

/* Gallery Indicators */
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
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: 2px solid white;
    cursor: pointer;
    transition: all 0.3s;
}

.gallery-indicator.active {
    background: white;
    width: 32px;
    border-radius: 5px;
}

/* =============== BOOKING CARD (SIDEBAR) =============== */
.booking-card {
    position: sticky;
    top: 120px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.15);
    overflow: hidden;
    border: 1px solid #e8f4f8;
}

.booking-card-header {
    background: linear-gradient(135deg, var(--resort-dark) 0%, var(--resort-secondary) 100%);
    padding: 28px 32px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.booking-card-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 50%;
}

.price-label {
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 600;
    margin-bottom: 12px;
}

.price-amount {
    font-size: 3rem;
    font-weight: 800;
    color: white;
    line-height: 1;
    margin-bottom: 8px;
    text-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.price-period {
    font-size: 1rem;
    color: rgba(255, 255, 255, 0.85);
    font-weight: 500;
}

.booking-card-body {
    padding: 32px;
}

/* Facilities List */
.facilities-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--resort-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.facilities-title::before {
    content: '';
    width: 4px;
    height: 22px;
    background: linear-gradient(180deg, var(--resort-primary), var(--resort-secondary));
    border-radius: 2px;
}

.facilities-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid;
    gap: 14px;
    margin-bottom: 32px;
}

.facility-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.04), rgba(70, 130, 180, 0.04));
    border-radius: 12px;
    border-left: 3px solid var(--resort-primary);
    transition: all 0.3s;
}

.facility-item:hover {
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.1), rgba(70, 130, 180, 0.1));
    transform: translateX(4px);
    border-left-color: var(--resort-secondary);
}

.facility-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, var(--resort-primary), var(--resort-secondary));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(135, 206, 235, 0.25);
}

.facility-icon svg {
    width: 18px;
    height: 18px;
    stroke: white;
    stroke-width: 2.5;
    fill: none;
}

.facility-text {
    font-size: 0.95rem;
    font-weight: 500;
    color: #334155;
}

/* Book Now Button */
.btn-book-resort {
    width: 100%;
    padding: 18px 24px;
    background: linear-gradient(135deg, var(--resort-gold) 0%, #B8860B 100%);
    border: none;
    border-radius: 14px;
    color: white;
    font-size: 1.05rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
    position: relative;
    overflow: hidden;
}

.btn-book-resort::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-book-resort:hover::before {
    width: 400px;
    height: 400px;
}

.btn-book-resort:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(212, 175, 55, 0.4);
}

.btn-book-resort svg {
    margin-right: 10px;
    vertical-align: middle;
}

/* =============== ROOM INFO SECTION =============== */
.room-info-section {
    max-width: 1400px;
    margin: 80px auto 60px;
    padding: 0 24px;
}

.room-header {
    margin-bottom: 40px;
}

.room-title {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    background: linear-gradient(135deg, var(--resort-dark) 0%, var(--resort-secondary) 60%, var(--resort-primary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
    line-height: 1.1;
}

.room-subtitle {
    font-size: 1.25rem;
    color: #64748b;
    font-weight: 500;
    max-width: 800px;
}

.title-divider {
    width: 140px;
    height: 6px;
    background: linear-gradient(90deg, var(--resort-gold), transparent);
    border-radius: 3px;
    margin: 24px 0 32px;
}

.room-description {
    font-size: 1.125rem;
    line-height: 2;
    color: #475569;
    background: white;
    padding: 48px;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(30, 58, 95, 0.08);
    border-left: 6px solid var(--resort-primary);
    max-width: 1000px;
}

/* =============== BOOKING MODAL =============== */
.modal-content {
    border: none;
    border-radius: 24px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.3);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, var(--resort-dark) 0%, var(--resort-secondary) 100%);
    color: white;
    padding: 28px 36px;
    border: none;
}

.modal-title {
    font-size: 1.6rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.9;
}

.btn-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 36px;
}

.form-section-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--resort-dark);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.form-label {
    font-weight: 600;
    color: #334155;
    margin-bottom: 10px;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-control {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 1rem;
    transition: all 0.3s;
    background: white;
}

.form-control:focus {
    border-color: var(--resort-primary);
    box-shadow: 0 0 0 4px rgba(135, 206, 235, 0.15);
    outline: none;
    background: white;
}

.selection-alert {
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.1) 0%, rgba(70, 130, 180, 0.08) 100%);
    border: 2px solid rgba(135, 206, 235, 0.3);
    border-radius: 16px;
    padding: 24px;
}

.alert-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--resort-dark);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.price-summary-box {
    background: linear-gradient(135deg, var(--resort-dark) 0%, var(--resort-secondary) 100%);
    color: white;
    padding: 28px;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 12px 30px rgba(30, 58, 95, 0.25);
    margin-top: 24px;
}

.price-summary-box h6 {
    font-size: 1rem;
    margin-bottom: 12px;
    opacity: 0.95;
    font-weight: 600;
}

.total-price {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0;
}

.btn-submit-booking {
    width: 100%;
    padding: 18px;
    background: linear-gradient(135deg, var(--resort-gold) 0%, #B8860B 100%);
    border: none;
    border-radius: 14px;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s;
    box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
    margin-top: 24px;
}

.btn-submit-booking:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 32px rgba(212, 175, 55, 0.4);
    color: white;
}

/* =============== RESPONSIVE =============== */
@media (max-width: 1024px) {
    .hero-grid {
        grid-template-columns: 1fr;
        gap: 32px;
    }

    .booking-card {
        position: relative;
        top: 0;
    }

    .main-image-container {
        height: 480px;
    }
}

@media (max-width: 768px) {
    .room-title {
        font-size: 2.5rem;
    }

    .main-image-container {
        height: 380px;
        border-radius: 16px;
    }

    .booking-card-body {
        padding: 24px;
    }

    .room-description {
        padding: 32px 24px;
        font-size: 1rem;
    }

    .price-amount {
        font-size: 2.5rem;
    }
}

/* =============== PLACEHOLDER =============== */
.image-placeholder {
    width: 100%;
    height: 600px;
    background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #64748b;
    font-size: 1.2rem;
}
</style>
@endpush

@section('content')
<div class="page-wrapper">

  {{-- BREADCRUMB --}}
  <section class="breadcrumb-section">
    <div class="container">
      <nav class="breadcrumb-nav">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-separator">›</span>
        <a href="{{ route('rooms.index') }}">Rooms</a>
        <span class="breadcrumb-separator">›</span>
        <span>{{ $room->name }}</span>
      </nav>
    </div>
  </section>

  {{-- HERO SECTION: IMAGE GALLERY + BOOKING CARD --}}
  <section class="room-hero-section">
    <div class="hero-container">
      <div class="hero-grid">

        {{-- IMAGE GALLERY --}}
        <div class="room-gallery">
          @if($room->images->isNotEmpty())
            <div class="main-image-container">
              <div id="roomGalleryCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                  @foreach($room->images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                      <img src="{{ asset('storage/' . $image->path) }}"
                           alt="{{ $room->name }}"
                           @if(!$loop->first) loading="lazy" @endif>
                    </div>
                  @endforeach
                </div>

                <button class="gallery-control prev" type="button" data-bs-target="#roomGalleryCarousel" data-bs-slide="prev">
                  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button class="gallery-control next" type="button" data-bs-target="#roomGalleryCarousel" data-bs-slide="next">
                  <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>

                <div class="gallery-indicators">
                  @foreach($room->images as $key => $image)
                    <button type="button"
                            data-bs-target="#roomGalleryCarousel"
                            data-bs-slide-to="{{ $key }}"
                            class="gallery-indicator {{ $loop->first ? 'active' : '' }}"
                            aria-label="Image {{ $key + 1 }}"></button>
                  @endforeach
                </div>
              </div>
            </div>
          @else
            <div class="image-placeholder">
              <div class="text-center">
                <h3>{{ $room->name }}</h3>
                <p>No images available</p>
              </div>
            </div>
          @endif
        </div>

        {{-- BOOKING CARD --}}
        <div class="booking-card">
          <div class="booking-card-header">
            <div class="price-label">Starting from</div>
            <div class="price-amount price-for-room-{{ $room->id }}">
              Rp {{ number_format($room->price, 0, ',', '.') }}
            </div>
            <div class="price-period">per night</div>
          </div>

          <div class="booking-card-body">
            <h3 class="facilities-title">Facilities & Amenities</h3>
            <ul class="facilities-list">
              @if(!empty($room->facilities))
                @foreach(explode("\n", $room->facilities) as $facility)
                  @php $facility = trim($facility); @endphp
                  @if($facility !== '')
                    <li class="facility-item">
                      <div class="facility-icon">
                        <svg viewBox="0 0 24 24">
                          <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                      </div>
                      <span class="facility-text">{{ $facility }}</span>
                    </li>
                  @endif
                @endforeach
              @else
                @foreach(['Wifi', 'Parking', 'AC', 'Shower', 'Air Panas', 'Bathroom Amenities', 'Free Airport Transfer'] as $facility)
                  <li class="facility-item">
                    <div class="facility-icon">
                      <svg viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                      </svg>
                    </div>
                    <span class="facility-text">{{ $facility }}</span>
                  </li>
                @endforeach
              @endif
            </ul>

            <button type="button" class="btn-book-resort" data-bs-toggle="modal" data-bs-target="#bookingModal">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              Book This Room
            </button>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- ROOM INFO SECTION --}}
  <section class="room-info-section">
    <div class="room-header">
      <h1 class="room-title">{{ $room->name }}</h1>
      <div class="title-divider"></div>
      <p class="room-subtitle">Discover comfort and elegance in our premium accommodation</p>
    </div>

    <div class="room-description">
      {!! nl2br(e($room->description)) !!}
    </div>
  </section>

</div>

{{-- BOOKING MODAL --}}
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingModalLabel">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            <polyline points="9 22 9 12 15 12 15 22"></polyline>
          </svg>
          Reserve {{ $room->name }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="{{ route('bookings.store') }}" method="POST">
          @csrf
          <input type="hidden" name="room_id" value="{{ $room->id }}">
          <input type="hidden" id="room_price_modal_{{ $room->id }}" value="{{ $room->price }}">

          @if(request('checkin') && request('checkout'))
            <input type="hidden" id="modal_checkin" name="checkin" value="{{ request('checkin') }}">
            <input type="hidden" id="modal_checkout" name="checkout" value="{{ request('checkout') }}">
            <input type="hidden" id="modal_num_rooms" name="num_rooms" value="{{ request('rooms', 1) }}">

            <div class="selection-alert">
              <div class="alert-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <circle cx="12" cy="12" r="10"></circle>
                  <line x1="12" y1="16" x2="12" y2="12"></line>
                  <line x1="12" y1="8" x2="12.01" y2="8"></line>
                </svg>
                Your Selection
              </div>
              <p class="mb-2"><strong>Check-in:</strong> {{ request('checkin') }}</p>
              <p class="mb-2"><strong>Check-out:</strong> {{ request('checkout') }}</p>
              <p class="mb-0"><strong>Rooms:</strong> {{ request('rooms', 1) }}</p>
            </div>
            <hr class="my-4">
          @else
            <h6 class="form-section-title">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
              </svg>
              Booking Dates
            </h6>
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="modal_checkin" class="form-label">Check-in Date</label>
                <input type="text" class="form-control datepicker" id="modal_checkin" name="checkin" placeholder="Select date" required>
              </div>
              <div class="col-md-6">
                <label for="modal_checkout" class="form-label">Check-out Date</label>
                <input type="text" class="form-control datepicker" id="modal_checkout" name="checkout" placeholder="Select date" required>
              </div>
              <div class="col-12">
                <label for="modal_num_rooms" class="form-label">Number of Rooms</label>
                <input type="number" class="form-control" id="modal_num_rooms" name="num_rooms" value="1" min="1" required>
              </div>
            </div>
            <hr class="my-4">
          @endif

          <h6 class="form-section-title">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
            Guest Information
          </h6>
          <div class="row g-3">
            <div class="col-12">
              <label for="guest_name" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="guest_name" name="guest_name" placeholder="Enter your full name" required>
            </div>
            <div class="col-md-6">
              <label for="guest_email" class="form-label">Email Address</label>
              <input type="email" class="form-control" id="guest_email" name="guest_email" placeholder="your@email.com" required>
            </div>
            <div class="col-md-6">
              <label for="guest_phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="guest_phone" name="guest_phone" placeholder="+62 xxx xxxx xxxx" required>
            </div>
          </div>

          <div id="price-calculation-modal" class="price-summary-box" style="display:none;">
            <h6>Total Estimated Cost</h6>
            <div class="total-price" id="total-price-modal">Rp 0</div>
          </div>

          <button type="submit" class="btn-submit-booking">
            @if(settings('booking_method', 'direct') == 'direct')
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
              </svg>
              Continue to Payment
            @else
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; vertical-align: middle; margin-right: 8px;">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
              </svg>
              Send Booking Request
            @endif
          </button>

          <p class="text-muted small mt-3 text-center">
            @if(settings('booking_method', 'direct') == 'direct')
              Secure payment processing • You will be redirected to payment page
            @else
              Our team will contact you via WhatsApp for confirmation
            @endif
          </p>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
@php
  $amenities = [];
  if (!empty($room->facilities)) {
      $facilitiesList = explode("\n", $room->facilities);
      foreach ($facilitiesList as $facility) {
          if (trim($facility) !== '') {
              $amenities[] = ['@type' => 'LocationFeatureSpecification', 'name' => trim($facility)];
          }
      }
  }
  $ld = [
      '@context' => 'https://schema.org',
      '@type'    => 'HotelRoom',
      'name'     => $room->name,
      'description' => \Illuminate\Support\Str::limit(strip_tags($room->description), 250),
      'offers'      => ['@type' => 'Offer', 'price' => (string) $room->price, 'priceCurrency' => 'IDR'],
  ];
  if ($room->images->isNotEmpty()) {
      $ld['image'] = asset('storage/' . $room->images->first()->path);
  }
  if (!empty($amenities)) {
      $ld['amenityFeature'] = $amenities;
  }
@endphp
<script type="application/ld+json">{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  // Price Calculator
  (function initPriceCalculator(){
    const checkinInput  = document.getElementById('modal_checkin');
    const checkoutInput = document.getElementById('modal_checkout');
    const numRoomsInput = document.getElementById('modal_num_rooms');
    const roomPriceInput= document.getElementById('room_price_modal_{{ $room->id }}');
    const priceBox      = document.getElementById('price-calculation-modal');
    const totalEl       = document.getElementById('total-price-modal');

    function update(){
      if(!checkinInput || !checkoutInput || !numRoomsInput || !roomPriceInput) return;
      const ci = checkinInput.value, co = checkoutInput.value;
      const n  = parseInt(numRoomsInput.value) || 0;
      const p  = parseFloat(roomPriceInput.value);
      if(ci && co && n>0 && p){
        const d1 = new Date(ci.split('-').reverse().join('-'));
        const d2 = new Date(co.split('-').reverse().join('-'));
        if(d2 > d1){
          const ms = d2 - d1;
          let days = Math.ceil(ms / (1000*3600*24));
          if (days < 1) days = 1;
          const total = p * n * days;
          totalEl.textContent = new Intl.NumberFormat('id-ID', {style:'currency', currency:'IDR', minimumFractionDigits:0}).format(total);
          priceBox.style.display = 'block';
          return;
        }
      }
      priceBox.style.display = 'none';
    }

    [checkinInput, checkoutInput].forEach(el => el && el.addEventListener('change', update));
    numRoomsInput && numRoomsInput.addEventListener('input', update);
    roomPriceInput && roomPriceInput.addEventListener('input', update);
    update();
  })();
});
</script>
@endpush
