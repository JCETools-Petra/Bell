@extends('layouts.frontend')

@section('seo_title', $room->seo_title ?: $room->name)
@section('meta_description', $room->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($room->description), 160))

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
/* =============== SKY BLUE OCEAN RESORT THEME =============== */
:root {
    --primary-blue: #87CEEB;
    --secondary-blue: #4682B4;
    --dark-blue: #1e3a5f;
    --accent-gold: #FFE4B5;
    --gradient-primary: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 50%, #87ceeb 100%);
}

body, .page-content-wrapper {
    background: linear-gradient(to bottom, #f0f8ff 0%, #ffffff 100%) !important;
    color: #333;
}

/* =============== MODERN HERO SECTION =============== */
.hero-section {
    padding: 40px 0 60px;
    background: linear-gradient(180deg, rgba(135, 206, 235, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
}

.modern-hero-slider {
    width: 100%;
    height: clamp(500px, 70vh, 750px);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.15);
    position: relative;
    background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
}

.modern-hero-slider::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, transparent 0%, rgba(0,0,0,0.03) 100%);
    z-index: 1;
    pointer-events: none;
}

.modern-hero-slider .carousel,
.modern-hero-slider .carousel-inner,
.modern-hero-slider .carousel-item {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
}

.modern-hero-slider .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 0.7s ease;
}

.modern-hero-slider .carousel-item.active img {
    animation: subtle-zoom 8s ease-in-out infinite alternate;
}

@keyframes subtle-zoom {
    from { transform: scale(1); }
    to { transform: scale(1.05); }
}

/* Modern Carousel Controls */
.carousel-control-prev,
.carousel-control-next {
    width: 60px;
    height: 60px;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, var(--primary-blue), var(--secondary-blue));
    border-radius: 50%;
    opacity: 0;
    transition: all 0.3s;
    z-index: 10;
}

.modern-hero-slider:hover .carousel-control-prev,
.modern-hero-slider:hover .carousel-control-next {
    opacity: 0.9;
}

.carousel-control-prev { left: 20px; }
.carousel-control-next { right: 20px; }

.carousel-control-prev:hover,
.carousel-control-next:hover {
    opacity: 1 !important;
    transform: translateY(-50%) scale(1.1);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: none;
    background-image: none;
}

.carousel-control-prev-icon::before,
.carousel-control-next-icon::before {
    content: '';
    display: block;
    width: 20px;
    height: 20px;
    border-top: 3px solid white;
    border-right: 3px solid white;
}

.carousel-control-prev-icon::before {
    transform: rotate(-135deg);
    margin-left: 5px;
}

.carousel-control-next-icon::before {
    transform: rotate(45deg);
    margin-right: 5px;
}

/* Modern Indicators */
.carousel-indicators {
    margin-bottom: 2rem;
    z-index: 10;
}

.carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255,255,255,0.5);
    border: 2px solid white;
    margin: 0 6px;
    transition: all 0.3s;
}

.carousel-indicators .active {
    background: white;
    width: 40px;
    border-radius: 6px;
}

/* =============== MODERN SIDEBAR CARD =============== */
.modern-sidebar-card {
    background: white;
    border: none;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.12);
    overflow: hidden;
    position: relative;
}

.modern-sidebar-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: var(--gradient-primary);
}

.card-header-modern {
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.1) 0%, rgba(70, 130, 180, 0.1) 100%);
    padding: 24px;
    border-bottom: 2px solid rgba(135, 206, 235, 0.2);
}

.card-header-modern h4 {
    font-size: 1.75rem;
    font-weight: 700;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

.price-badge {
    background: var(--gradient-primary);
    color: white;
    padding: 20px 24px;
    border-radius: 16px;
    margin: 24px;
    text-align: center;
    box-shadow: 0 8px 24px rgba(135, 206, 235, 0.3);
}

.price-badge .price-label {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-bottom: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.price-badge .price-amount {
    font-size: 2rem;
    font-weight: 800;
    margin: 0;
}

.price-badge .price-per {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-top: 4px;
}

/* =============== FACILITIES SECTION =============== */
.facilities-section {
    padding: 24px;
}

.facilities-section h5 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark-blue);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.facilities-section h5::before {
    content: '';
    width: 4px;
    height: 24px;
    background: var(--gradient-primary);
    border-radius: 2px;
    margin-right: 12px;
}

.facility-item {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    margin-bottom: 10px;
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.05) 0%, rgba(70, 130, 180, 0.05) 100%);
    border-radius: 12px;
    border-left: 3px solid var(--primary-blue);
    transition: all 0.3s;
}

.facility-item:hover {
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.15) 0%, rgba(70, 130, 180, 0.15) 100%);
    transform: translateX(5px);
    border-left-color: var(--secondary-blue);
}

.facility-icon {
    width: 32px;
    height: 32px;
    background: var(--gradient-primary);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
}

.facility-icon svg {
    width: 16px;
    height: 16px;
    fill: white;
}

.facility-text {
    font-size: 0.95rem;
    color: #333;
    font-weight: 500;
}

/* =============== BOOK NOW BUTTON =============== */
.btn-book-now {
    width: 100%;
    padding: 16px 24px;
    margin: 24px;
    margin-top: 0;
    background: var(--gradient-primary);
    border: none;
    border-radius: 14px;
    color: white;
    font-size: 1.1rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 8px 24px rgba(135, 206, 235, 0.4);
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
}

.btn-book-now::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-book-now:hover::before {
    width: 300px;
    height: 300px;
}

.btn-book-now:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(135, 206, 235, 0.5);
    color: white;
}

/* =============== ROOM INFO SECTION =============== */
.room-info-section {
    margin-top: 60px;
    padding: 50px 0;
}

.room-title {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 800;
    background: var(--gradient-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 24px;
    line-height: 1.2;
}

.title-divider {
    width: 120px;
    height: 5px;
    background: var(--gradient-primary);
    border-radius: 3px;
    margin-bottom: 32px;
}

.room-description {
    font-size: 1.125rem;
    line-height: 1.9;
    color: #555;
    text-align: justify;
    padding: 32px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(30, 58, 95, 0.08);
    border-left: 5px solid var(--primary-blue);
}

/* =============== MODERN BOOKING MODAL =============== */
.modal-content {
    border: none;
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    overflow: hidden;
}

.modal-header {
    background: var(--gradient-primary);
    color: white;
    padding: 24px 32px;
    border: none;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
}

.btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.btn-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 32px;
}

.form-label {
    font-weight: 600;
    color: var(--dark-blue);
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-control {
    border: 2px solid rgba(135, 206, 235, 0.3);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s;
}

.form-control:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(135, 206, 235, 0.1);
    outline: none;
}

.alert-selection {
    background: linear-gradient(135deg, rgba(135, 206, 235, 0.1) 0%, rgba(70, 130, 180, 0.1) 100%);
    border: 2px solid rgba(135, 206, 235, 0.3);
    border-radius: 16px;
    padding: 20px;
}

.alert-heading {
    color: var(--dark-blue);
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 16px;
}

.price-calculation-box {
    background: var(--gradient-primary);
    color: white;
    padding: 20px;
    border-radius: 16px;
    text-align: center;
    box-shadow: 0 8px 24px rgba(135, 206, 235, 0.3);
}

.price-calculation-box h6 {
    font-size: 1rem;
    margin-bottom: 8px;
    opacity: 0.9;
}

.total-price-display {
    font-size: 2rem;
    font-weight: 800;
}

.btn-submit {
    width: 100%;
    padding: 16px;
    background: var(--gradient-primary);
    border: none;
    border-radius: 12px;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s;
    box-shadow: 0 6px 20px rgba(135, 206, 235, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(135, 206, 235, 0.4);
    color: white;
}

/* =============== STICKY SIDEBAR =============== */
@media (min-width: 992px) {
    .sidebar-sticky {
        position: sticky;
        top: 100px;
    }
}

/* =============== MOBILE RESPONSIVE =============== */
@media (max-width: 991.98px) {
    .modern-hero-slider {
        height: clamp(380px, 60vh, 600px);
    }

    .room-title {
        font-size: 2rem;
    }

    .room-description {
        padding: 24px;
        font-size: 1rem;
    }
}

/* =============== PLACEHOLDER =============== */
.placeholder-hero {
    height: clamp(420px, 60vh, 640px);
    display: grid;
    place-items: center;
    color: #777;
    border-radius: 24px;
    background: linear-gradient(135deg, #f0f8ff 0%, #e6f3ff 100%);
    box-shadow: 0 20px 60px rgba(30, 58, 95, 0.15);
}

.placeholder-hero h2 {
    color: var(--dark-blue);
    margin-bottom: 12px;
}
</style>
@endpush

@section('content')
<div class="page-content-wrapper">

  {{-- =================== HERO SECTION: SLIDER + SIDEBAR =================== --}}
  <section class="hero-section">
    <div class="container">
      <div class="row g-4 align-items-start">
        {{-- LEFT: IMAGE SLIDER --}}
        <div class="col-lg-8">
          @if($room->images->isNotEmpty())
            <div class="modern-hero-slider">
              <div id="roomHeroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
                <div class="carousel-indicators">
                  @foreach($room->images as $key => $image)
                    <button type="button"
                            data-bs-target="#roomHeroCarousel"
                            data-bs-slide-to="{{ $key }}"
                            class="{{ $loop->first ? 'active' : '' }}"
                            aria-label="Slide {{ $key + 1 }}"></button>
                  @endforeach
                </div>
                <div class="carousel-inner">
                  @foreach($room->images as $image)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                      <img src="{{ asset('storage/' . $image->path) }}"
                           alt="Photo of {{ $room->name }}"
                           @if(!$loop->first) loading="lazy" @endif>
                    </div>
                  @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#roomHeroCarousel" data-bs-slide="prev" aria-label="Previous">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#roomHeroCarousel" data-bs-slide="next" aria-label="Next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
              </div>
            </div>
          @else
            <div class="placeholder-hero text-center">
              <div>
                <h2>{{ $room->name }}</h2>
                <p>No images available yet.</p>
              </div>
            </div>
          @endif
        </div>

        {{-- RIGHT: ROOM DETAILS SIDEBAR --}}
        <div class="col-lg-4">
          <div class="modern-sidebar-card sidebar-sticky">
            <div class="card-header-modern">
              <h4>Room Details</h4>
            </div>

            <div class="price-badge">
              <div class="price-label">Starting from</div>
              <div class="price-amount price-for-room-{{ $room->id }}">
                Rp {{ number_format($room->price, 0, ',', '.') }}
              </div>
              <div class="price-per">per night</div>
            </div>

            <div class="facilities-section">
              <h5>Facilities & Amenities</h5>
              @if(!empty($room->facilities))
                @foreach(explode("\n", $room->facilities) as $facility)
                  @php $facility = trim($facility); @endphp
                  @if($facility !== '')
                    <div class="facility-item">
                      <div class="facility-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                      </div>
                      <span class="facility-text">{{ $facility }}</span>
                    </div>
                  @endif
                @endforeach
              @else
                @foreach(["Wifi","Parking","AC","Shower","Air Panas","Bathroom amenities","Free antar jemput Bandara Mopa Merauke"] as $facility)
                  <div class="facility-item">
                    <div class="facility-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                      </svg>
                    </div>
                    <span class="facility-text">{{ $facility }}</span>
                  </div>
                @endforeach
              @endif
            </div>

            <button type="button" class="btn-book-now" data-bs-toggle="modal" data-bs-target="#bookingModal">
              <i class="fas fa-calendar-check me-2"></i> Book Now
            </button>
          </div>
        </div>
      </div>

      {{-- ROOM INFO: TITLE + DESCRIPTION --}}
      <div class="row room-info-section">
        <div class="col-lg-10 mx-auto">
          <h1 class="room-title">{{ $room->name }}</h1>
          <div class="title-divider"></div>
          <div class="room-description">
            {!! nl2br(e($room->description)) !!}
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

{{-- =================== MODERN BOOKING MODAL =================== --}}
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingModalLabel">
          <i class="fas fa-bed me-2"></i> Book {{ $room->name }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('bookings.store') }}" method="POST">
          @csrf
          <input type="hidden" name="room_id" value="{{ $room->id }}">
          <input type="hidden" id="room_price_modal_{{ $room->id }}" value="{{ $room->price }}">

          @if(request('checkin') && request('checkout'))
            <input type="hidden" id="modal_checkin"  name="checkin"  value="{{ request('checkin') }}">
            <input type="hidden" id="modal_checkout" name="checkout" value="{{ request('checkout') }}">
            <input type="hidden" id="modal_num_rooms" name="num_rooms" value="{{ request('rooms', 1) }}">
            <div class="alert-selection">
              <h6 class="alert-heading">
                <i class="fas fa-info-circle me-2"></i> Your Selection
              </h6>
              <p class="mb-2"><strong>Check-in:</strong> {{ request('checkin') }}</p>
              <p class="mb-2"><strong>Check-out:</strong> {{ request('checkout') }}</p>
              <p class="mb-0"><strong>Rooms:</strong> {{ request('rooms', 1) }}</p>
            </div>
            <hr class="my-4">
          @else
            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="modal_checkin" class="form-label">
                  <i class="fas fa-calendar-alt me-2"></i> Check-in Date
                </label>
                <input type="text" class="form-control datepicker" id="modal_checkin" name="checkin" placeholder="Select Date" required>
              </div>
              <div class="col-md-6">
                <label for="modal_checkout" class="form-label">
                  <i class="fas fa-calendar-alt me-2"></i> Check-out Date
                </label>
                <input type="text" class="form-control datepicker" id="modal_checkout" name="checkout" placeholder="Select Date" required>
              </div>
              <div class="col-md-12">
                <label for="modal_num_rooms" class="form-label">
                  <i class="fas fa-door-open me-2"></i> Number of Rooms
                </label>
                <input type="number" class="form-control" id="modal_num_rooms" name="num_rooms" value="1" min="1" required>
              </div>
            </div>
            <hr class="my-4">
          @endif

          <h6 class="mt-4 mb-3" style="color: var(--dark-blue); font-weight: 700;">
            <i class="fas fa-user me-2"></i> Guest Information
          </h6>
          <div class="row g-3">
            <div class="col-md-12">
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

          <div id="price-calculation-modal" class="price-calculation-box mt-4" style="display:none;">
            <h6>Estimated Total Cost</h6>
            <div class="total-price-display" id="total-price-modal">Rp 0</div>
          </div>

          <div class="d-grid mt-4">
            @if(settings('booking_method', 'direct') == 'direct')
              <button type="submit" class="btn-submit">
                <i class="fas fa-credit-card me-2"></i> Continue to Payment
              </button>
            @else
              <button type="submit" class="btn-submit">
                <i class="fab fa-whatsapp me-2"></i> Send Booking Request
              </button>
            @endif
          </div>

          @if(settings('booking_method', 'direct') == 'direct')
            <p class="text-muted small mt-3 text-center">
              <i class="fas fa-shield-alt me-1"></i> You will proceed to payment page after completing this form.
            </p>
          @else
            <p class="text-muted small mt-3 text-center">
              <i class="fab fa-whatsapp me-1"></i> Our team will contact you via WhatsApp for confirmation and payment.
            </p>
          @endif
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
