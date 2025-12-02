@extends('layouts.frontend')

@section('seo_title', $room->seo_title ?: $room->name . ' - Sora Hotel Merauke')
@section('meta_description', $room->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($room->description), 160))

@section('content')
    {{-- HEADER IMAGE / BREADCRUMB --}}
    <div class="bg-brand-dark pt-32 pb-16 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-30">
            @if($room->images->isNotEmpty())
                <img src="{{ asset('storage/' . $room->images->first()->path) }}" class="w-full h-full object-cover blur-sm">
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/80 to-transparent"></div>
        </div>
        <div class="container mx-auto px-4 relative z-10">
            <nav class="flex text-sm text-gray-400 mb-6">
                <a href="{{ route('home') }}" class="hover:text-brand-secondary transition-colors">Home</a>
                <span class="mx-3 text-gray-600">/</span>
                <a href="{{ route('rooms.index') }}" class="hover:text-brand-secondary transition-colors">Rooms</a>
                <span class="mx-3 text-gray-600">/</span>
                <span class="text-brand-secondary font-medium">{{ $room->name }}</span>
            </nav>
            <h1 class="text-4xl md:text-6xl font-heading font-bold text-white mb-4 leading-tight">{{ $room->name }}</h1>
            <div class="flex items-center gap-4">
                <span class="bg-brand-secondary/20 text-brand-secondary px-4 py-1 rounded-full text-sm font-bold border border-brand-secondary/30">
                    {{ $room->type ?? 'Premium Room' }}
                </span>
                <p class="text-white text-2xl font-light">
                    Rp {{ number_format($room->price, 0, ',', '.') }} <span class="text-sm text-gray-400">/ night</span>
                </p>
            </div>
        </div>
    </div>

    <div class="bg-brand-light py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
                
                {{-- KOLOM KIRI: GALERI & DESKRIPSI --}}
                <div class="lg:col-span-2 space-y-10">
                    
                    {{-- 1. Modern Gallery --}}
                    <div class="bg-white rounded-[2rem] shadow-sm p-3 border border-gray-100 overflow-hidden">
                        @if($room->images->isNotEmpty())
                            {{-- Main Image --}}
                            <div class="relative h-[400px] md:h-[550px] rounded-2xl overflow-hidden mb-3 group">
                                <img id="mainImage" src="{{ asset('storage/' . $room->images->first()->path) }}" 
                                     alt="{{ $room->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            {{-- Thumbnails --}}
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($room->images as $image)
                                    <button onclick="changeImage('{{ asset('storage/' . $image->path) }}')" 
                                            class="relative h-20 md:h-28 rounded-xl overflow-hidden cursor-pointer opacity-70 hover:opacity-100 transition-all hover:ring-2 hover:ring-brand-secondary focus:outline-none focus:ring-2 focus:ring-brand-secondary transform hover:-translate-y-1">
                                        <img src="{{ asset('storage/' . $image->path) }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div class="h-[400px] bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl mb-2 opacity-50"></i>
                                    <p>No Images Available</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- 2. Description --}}
                    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">
                        <h3 class="text-2xl font-heading font-bold text-brand-primary mb-6 flex items-center gap-3">
                            <i class="fas fa-align-left text-brand-secondary"></i> About This Room
                        </h3>
                        <div class="prose max-w-none text-gray-600 leading-relaxed space-y-4 font-light text-lg">
                            {!! nl2br(e($room->description)) !!}
                        </div>
                    </div>

                    {{-- 3. Amenities --}}
                    <div class="bg-white rounded-[2rem] shadow-sm p-8 border border-gray-100">
                        <h3 class="text-2xl font-heading font-bold text-brand-primary mb-8 flex items-center gap-3">
                            <i class="fas fa-concierge-bell text-brand-secondary"></i> Room Amenities
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-y-6 gap-x-8">
                            @php
                                $facilities = !empty($room->facilities) 
                                    ? explode("\n", $room->facilities) 
                                    : ["Free WiFi", "AC", "TV Cable", "Hot Shower", "Amenities", "Mineral Water"];
                            @endphp
                            
                            @foreach($facilities as $facility)
                                @if(trim($facility) !== '')
                                <div class="flex items-center text-gray-700 group">
                                    <span class="w-10 h-10 rounded-full bg-brand-light text-brand-secondary flex items-center justify-center mr-4 flex-shrink-0 group-hover:bg-brand-secondary group-hover:text-white transition-colors">
                                        <i class="fas fa-check text-sm"></i>
                                    </span>
                                    <span class="text-base font-medium">{{ trim($facility) }}</span>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- KOLOM KANAN: BOOKING FORM (Sticky) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-28 space-y-8">
                        
                        {{-- Booking Card --}}
                        <div class="bg-white rounded-[2rem] shadow-xl border border-gray-100 overflow-hidden relative">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-brand-primary to-brand-secondary"></div>
                            <div class="p-8">
                                <h3 class="text-xl font-bold text-brand-primary mb-6 text-center">Book Your Stay</h3>
                                
                                <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                                    @csrf
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <input type="hidden" id="room_price" value="{{ $room->price }}">

                                    {{-- Date Selection --}}
                                    <div class="space-y-5 mb-6">
                                        <div>
                                            <label class="block text-xs font-bold text-brand-primary uppercase tracking-wide mb-2">Check-in</label>
                                            <div class="relative group">
                                                <input type="text" class="datepicker w-full bg-brand-light border-transparent rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-secondary focus:bg-white transition-all font-medium text-brand-dark" 
                                                       id="checkin" name="checkin" value="{{ request('checkin') }}" placeholder="Select Date" required>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                                    <i class="fas fa-calendar text-brand-secondary"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-bold text-brand-primary uppercase tracking-wide mb-2">Check-out</label>
                                            <div class="relative group">
                                                <input type="text" class="datepicker w-full bg-brand-light border-transparent rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-secondary focus:bg-white transition-all font-medium text-brand-dark" 
                                                       id="checkout" name="checkout" value="{{ request('checkout') }}" placeholder="Select Date" required>
                                                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                                    <i class="fas fa-calendar text-brand-secondary"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Room Count --}}
                                    <div class="mb-6">
                                        <label class="block text-xs font-bold text-brand-primary uppercase tracking-wide mb-2">Number of Rooms</label>
                                        <div class="relative">
                                            <input type="number" class="w-full bg-brand-light border-transparent rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-secondary focus:bg-white transition-all font-medium text-brand-dark" 
                                                   id="num_rooms" name="num_rooms" value="{{ request('rooms', 1) }}" min="1" required>
                                        </div>
                                    </div>

                                    {{-- Guest Info --}}
                                    <div class="space-y-4 pt-6 border-t border-gray-100">
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wide text-center">Guest Information</p>
                                        <input type="text" name="guest_name" class="w-full bg-brand-light border-transparent rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-secondary focus:bg-white transition-all" placeholder="Full Name" required>
                                        <input type="email" name="guest_email" class="w-full bg-brand-light border-transparent rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-secondary focus:bg-white transition-all" placeholder="Email Address" required>
                                        <input type="tel" name="guest_phone" class="w-full bg-brand-light border-transparent rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand-secondary focus:bg-white transition-all" placeholder="WhatsApp Number" required>
                                    </div>

                                    {{-- Price Calculation Display --}}
                                    <div id="price-summary" class="mt-8 p-5 bg-brand-light rounded-xl border border-blue-100 hidden">
                                        <div class="flex justify-between text-sm mb-3">
                                            <span class="text-gray-600">Price x <span id="night-count" class="font-bold">0</span> Nights</span>
                                            <span class="font-medium text-brand-dark" id="base-total">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between text-lg font-bold border-t border-blue-200 pt-3 mt-2">
                                            <span class="text-brand-primary">Total</span>
                                            <span class="text-brand-secondary" id="grand-total">Rp 0</span>
                                        </div>
                                    </div>

                                    {{-- Submit Button --}}
                                    <button type="submit" class="w-full mt-8 bg-brand-primary hover:bg-brand-secondary text-white font-bold py-4 rounded-xl transition-all duration-300 shadow-lg shadow-brand-primary/30 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                        @if(settings('booking_method', 'direct') == 'direct')
                                            Proceed to Payment <i class="fas fa-lock text-xs opacity-70"></i>
                                        @else
                                            Book via WhatsApp <i class="fab fa-whatsapp text-lg"></i>
                                        @endif
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Contact Support --}}
                        <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100 text-center">
                            <p class="text-sm text-gray-500 mb-3 font-medium">Need help booking?</p>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', settings('contact_phone') ?? '6281234567890') }}" target="_blank" class="text-green-600 font-bold hover:text-green-700 transition-colors flex items-center justify-center gap-2 bg-green-50 py-3 rounded-xl hover:bg-green-100">
                                <i class="fab fa-whatsapp text-xl"></i> Chat with Admin
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script untuk Galeri & Kalkulasi Harga --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    <script>
        // 1. Image Gallery Switcher
        function changeImage(src) {
            const mainImage = document.getElementById('mainImage');
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = src;
                mainImage.style.opacity = '1';
            }, 200);
        }

        // 2. Inisialisasi Flatpickr & Kalkulator
        document.addEventListener('DOMContentLoaded', function() {
            
            flatpickr(".datepicker", {
                dateFormat: "d-m-Y",
                minDate: "today",
                disableMobile: "true"
            });

            const checkin = document.getElementById('checkin');
            const checkout = document.getElementById('checkout');
            const numRooms = document.getElementById('num_rooms');
            const roomPrice = parseFloat(document.getElementById('room_price').value);
            const summaryBox = document.getElementById('price-summary');
            
            function calculateTotal() {
                if(checkin.value && checkout.value) {
                    const d1 = checkin.value.split('-').reverse().join('-');
                    const d2 = checkout.value.split('-').reverse().join('-');
                    
                    const date1 = new Date(d1);
                    const date2 = new Date(d2);
                    
                    if (date2 > date1) {
                        const timeDiff = Math.abs(date2 - date1);
                        const diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
                        const rooms = parseInt(numRooms.value) || 1;
                        
                        const total = roomPrice * diffDays * rooms;
                        
                        document.getElementById('night-count').innerText = diffDays;
                        document.getElementById('base-total').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
                        document.getElementById('grand-total').innerText = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(total);
                        
                        summaryBox.classList.remove('hidden');
                        summaryBox.classList.add('block');
                    } else {
                        summaryBox.classList.add('hidden');
                        summaryBox.classList.remove('block');
                    }
                }
            }

            [checkin, checkout, numRooms].forEach(el => {
                if(el) {
                    el.addEventListener('change', calculateTotal);
                    el.addEventListener('input', calculateTotal);
                }
            });
            
            // Initial check
            calculateTotal();
        });
    </script>
    @endpush
@endsection


