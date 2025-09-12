@extends('layouts.frontend')

@section('seo_title', $room->seo_title ?: $room->name)
@section('meta_description', $room->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($room->description), 160))

@section('content')
<div class="page-content-wrapper">
    <div class="container">
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Please check the form below for errors.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                @if($room->images->isNotEmpty())
                    <div id="roomCarousel" class="carousel slide shadow-lg rounded overflow-hidden mb-4" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach($room->images as $key => $image)
                                <button type="button" data-bs-target="#roomCarousel" data-bs-slide-to="{{ $key }}" class="{{ $loop->first ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($room->images as $image)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->path) }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="{{ $room->name }} - Gambar {{ $loop->iteration }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                @else
                    <img src="https://via.placeholder.com/800x500?text=No+Image+Available" class="img-fluid rounded shadow-lg mb-4" alt="No Image Available">
                @endif

                <h1 class="display-4">{{ $room->name }}</h1>
                <hr style="border-color: var(--color-gold); border-width: 2px; width: 100px; opacity: 1;">
                <p class="lead mt-4" style="text-align: justify;">
                    {!! nl2br(e($room->description)) !!}
                </p>
            </div>

            <div class="col-lg-4">
                <div class="card sticky-top" style="top: 110px;">
                    <div class="card-body">
                        <h4 class="card-title h2">Room Details</h4>
                        <hr>
                        <p class="card-price mb-4">
                            <strong>Price:</strong> Rp {{ number_format($room->price, 0, ',', '.') }} / night
                        </p>
                        <h5 class="mt-4">Facilities</h5>
                        <ul class="list-unstyled">
                            @foreach(explode("\n", $room->facilities) as $facility)
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
                        <button type="button" class="btn btn-custom w-100 mt-3" data-bs-toggle="modal" data-bs-target="#bookingModal">
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bookingModalLabel">Booking Form: {{ $room->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('bookings.store') }}" method="POST">
            @csrf
            
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" id="room_price_modal" value="{{ $room->price }}">

            @if(request('checkin') && request('checkout'))
                <input type="hidden" id="modal_checkin" name="checkin" value="{{ request('checkin') }}">
                <input type="hidden" id="modal_checkout" name="checkout" value="{{ request('checkout') }}">
                <input type="hidden" id="modal_num_rooms" name="num_rooms" value="{{ request('rooms', 1) }}">
                <div class="alert alert-light border">
                    <h6 class="alert-heading">Your Selection</h6>
                    <p class="mb-1"><strong>Check-in:</strong> {{ request('checkin') }}</p>
                    <p class="mb-1"><strong>Check-out:</strong> {{ request('checkout') }}</p>
                    <p class="mb-0"><strong>Rooms:</strong> {{ request('rooms', 1) }}</p>
                </div>
                <hr>
            @else
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="modal_checkin" class="form-label">Check-in Date</label>
                        <input type="text" class="form-control" id="modal_checkin" name="checkin" placeholder="Select Date" required>
                    </div>
                    <div class="col-md-6">
                        <label for="modal_checkout" class="form-label">Check-out Date</label>
                        <input type="text" class="form-control" id="modal_checkout" name="checkout" placeholder="Select Date" required>
                    </div>
                    <div class="col-md-12">
                        <label for="modal_num_rooms" class="form-label">Number of Rooms</label>
                        <input type="number" class="form-control" id="modal_num_rooms" name="num_rooms" value="1" min="1" required>
                    </div>
                </div>
                <hr>
            @endif
            
            <h6 class="mt-4">Guest Information</h6>
            <div class="mb-3">
                <label for="guest_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="guest_name" name="guest_name" required>
            </div>
            <div class="mb-3">
                <label for="guest_email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="guest_email" name="guest_email" required>
            </div>
             <div class="mb-3">
                <label for="guest_phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="guest_phone" name="guest_phone" required>
            </div>
            
            {{-- Elemen untuk menampilkan total harga --}}
            <div id="price-calculation-modal" class="mt-4 p-3 bg-light rounded" style="display: none;">
                <h6 class="mb-0">Estimasi Total Biaya: <span id="total-price-modal" class="text-primary fw-bold">Rp 0</span></h6>
            </div>

            <div class="d-grid mt-4">
                {{-- ========================================================== --}}
                {{--         UBAH TOMBOL SUBMIT MENJADI KONDISIONAL           --}}
                {{-- ========================================================== --}}
                @if(settings('booking_method', 'direct') == 'direct')
                    <button type="submit" class="btn btn-custom">Lanjutkan ke Pembayaran</button>
                @else
                    <button type="submit" class="btn btn-custom">Kirim Permintaan Booking</button>
                @endif
            </div>
            
            {{-- Ubah juga teks helper di bawah tombol --}}
            @if(settings('booking_method', 'direct') == 'direct')
                <p class="text-muted small mt-3">*Anda akan melanjutkan ke halaman pembayaran setelah mengisi formulir ini.</p>
            @else
                <p class="text-muted small mt-3">*Admin kami akan segera menghubungi Anda melalui WhatsApp untuk konfirmasi dan pembayaran.</p>
            @endif
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('scripts')
@php
    // Memproses daftar fasilitas untuk amenityFeature
    $amenities = [];
    if (!empty($room->facilities)) {
        $facilitiesList = explode("\n", $room->facilities);
        foreach ($facilitiesList as $facility) {
            if (trim($facility) !== '') {
                $amenities[] = [
                    '@type' => 'LocationFeatureSpecification',
                    'name'  => trim($facility),
                ];
            }
        }
    }

    // Siapkan JSON-LD sebagai array, lalu encode sekali
    $ld = [
        '@context'    => 'https://schema.org',
        '@type'       => 'HotelRoom',
        'name'        => $room->name,
        'description' => \Illuminate\Support\Str::limit(strip_tags($room->description), 250),
        'offers'      => [
            '@type'         => 'Offer',
            'price'         => (string) $room->price,
            'priceCurrency' => 'IDR',
        ],
    ];

    if ($room->images->isNotEmpty()) {
        $ld['image'] = asset('storage/' . $room->images->first()->path);
    }

    if (!empty($amenities)) {
        $ld['amenityFeature'] = $amenities;
    }
@endphp
<script type="application/ld+json">
{!! json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

{{-- Skrip untuk Datepicker dan Kalkulasi Harga --}}
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        function initializePriceCalculator() {
            const checkinInput = document.getElementById('modal_checkin');
            const checkoutInput = document.getElementById('modal_checkout');
            const numRoomsInput = document.getElementById('modal_num_rooms');
            const roomPrice = parseFloat(document.getElementById('room_price_modal').value);
            const priceDisplayContainer = document.getElementById('price-calculation-modal');
            const totalPriceElement = document.getElementById('total-price-modal');

            // Inisialisasi Date Picker
            const today = new Date();
            flatpickr(checkinInput, {
                dateFormat: "d-m-Y",
                minDate: today,
                onChange: function(selectedDates, dateStr, instance) {
                    const checkoutPicker = flatpickr.instance["#modal_checkout"];
                    if (selectedDates.length > 0) {
                        checkoutPicker.set('minDate', new Date(selectedDates[0]).fp_incr(1));
                    }
                    updatePrice();
                }
            });

            flatpickr(checkoutInput, {
                dateFormat: "d-m-Y",
                onChange: function(selectedDates, dateStr, instance) {
                    updatePrice();
                }
            });

            // Tambahkan event listener ke input jumlah kamar
            numRoomsInput.addEventListener('input', updatePrice);

            // Fungsi untuk mengupdate harga
            function updatePrice() {
                const checkinDateStr = checkinInput.value;
                const checkoutDateStr = checkoutInput.value;
                const numRooms = parseInt(numRoomsInput.value) || 0;

                if (checkinDateStr && checkoutDateStr && numRooms > 0) {
                    const checkinDate = new Date(checkinDateStr.split('-').reverse().join('-'));
                    const checkoutDate = new Date(checkoutDateStr.split('-').reverse().join('-'));

                    if (checkoutDate > checkinDate) {
                        const timeDiff = checkoutDate.getTime() - checkinDate.getTime();
                        let durationInDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                        
                        if (durationInDays < 1) {
                            durationInDays = 1;
                        }

                        const total = roomPrice * numRooms * durationInDays;

                        totalPriceElement.textContent = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            minimumFractionDigits: 0
                        }).format(total);

                        priceDisplayContainer.style.display = 'block';
                    } else {
                        priceDisplayContainer.style.display = 'none';
                    }
                } else {
                    priceDisplayContainer.style.display = 'none';
                }
            }
            
            // Panggil sekali saat inisialisasi jika ada nilai dari URL
            updatePrice();
        }

        // Panggil fungsi inisialisasi
        initializePriceCalculator();

        // Jika modal ditutup, reset nilai datepicker agar tidak bentrok
        const bookingModal = document.getElementById('bookingModal');
        bookingModal.addEventListener('hidden.bs.modal', function (event) {
            const checkinPicker = flatpickr.instance["#modal_checkin"];
            const checkoutPicker = flatpickr.instance["#modal_checkout"];
            if (checkinPicker) {
                checkinPicker.clear();
            }
            if (checkoutPicker) {
                checkoutPicker.clear();
            }
        });
    });
</script>
@endpush