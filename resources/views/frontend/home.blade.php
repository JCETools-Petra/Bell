@extends('layouts.frontend')

@section('title', 'Home - Sora Hotel Merauke')

@section('content')
    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    {{-- RUNNING TEXT SECTION --}}
    @if($runningTextStatus == '1' || $runningTextStatus == 'true')
        {{-- 
            PERBAIKAN: 
            1. 'fixed': Agar melayang dan TIDAK mendorong gambar ke bawah (menghilangkan putih).
            2. 'top-[100px]': Menambah jarak dari atas agar tidak tertutup Navbar (sesuaikan angka ini jika perlu).
            3. 'z-40': Agar berada di bawah layer Navbar (biasanya z-50).
        --}}
        <div class="fixed top-[97px] left-0 w-full z-40 bg-brand-primary/90 backdrop-blur-sm text-white py-2 border-b border-white/10 shadow-lg">
            <div class="container mx-auto px-4">
                <div class="flex items-center">
                    <div class="bg-brand-secondary text-xs font-bold px-2 py-1 rounded mr-3 uppercase tracking-wider shrink-0 animate-pulse">
                        Info
                    </div>
                    <marquee class="font-medium text-sm tracking-wide" behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                        {{ $runningTextContent ?? 'Welcome to Sora Hotel Merauke' }}
                    </marquee>
                </div>
            </div>
        </div>
    @endif
    {{-- 1. HERO SECTION --}}
    <div class="relative w-full h-screen overflow-hidden bg-brand-dark">
        <div class="swiper hero-swiper h-full w-full">
            <div class="swiper-wrapper">
                @if(isset($heroSliders) && count($heroSliders) > 0)
                    @foreach($heroSliders as $slider)
                        <div class="swiper-slide relative">
                            <img src="{{ asset('storage/' . $slider->image_path) }}" class="w-full h-full object-cover" alt="Sora Hotel">
                            {{-- Blue Gradient Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-b from-brand-primary/60 via-brand-primary/20 to-brand-dark/90 mix-blend-multiply"></div>
                            <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                                <div class="max-w-5xl" data-aos="fade-up">
                                    <span class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-brand-secondary tracking-[0.2em] uppercase text-xs md:text-sm font-bold mb-6 animate-fade-in-up">
                                        Welcome to Sora Hotel Merauke
                                    </span>
                                    <h1 class="text-5xl md:text-7xl lg:text-8xl font-heading font-bold text-white mb-6 leading-tight drop-shadow-2xl animate-fade-in-up delay-100">
                                        {{ $slider->title ?? 'Escape to Paradise' }}
                                    </h1>
                                    <p class="text-gray-100 text-lg md:text-2xl font-light mb-10 max-w-2xl mx-auto animate-fade-in-up delay-200 drop-shadow-md">
                                        {{ $slider->subtitle ?? 'Experience the ultimate luxury and comfort in the heart of Papua.' }}
                                    </p>
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-up delay-300">
                                        <a href="#rooms" class="inline-block bg-brand-secondary hover:bg-white hover:text-brand-primary text-white font-bold py-4 px-10 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg shadow-brand-secondary/30">
                                            Discover More
                                        </a>
                                        <a href="{{ route('contact.index') }}" class="inline-block bg-transparent border-2 border-white text-white hover:bg-white hover:text-brand-primary font-bold py-4 px-10 rounded-full transition-all duration-300">
                                            Contact Us
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Fallback Slide --}}
                    <div class="swiper-slide relative">
                        <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1920&auto=format&fit=crop" class="w-full h-full object-cover" alt="Sora Hotel">
                        <div class="absolute inset-0 bg-gradient-to-b from-brand-primary/60 via-brand-primary/20 to-brand-dark/90 mix-blend-multiply"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-center px-4">
                            <div class="max-w-5xl">
                                <span class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-brand-secondary tracking-[0.2em] uppercase text-xs md:text-sm font-bold mb-6">
                                    Welcome to Sora Hotel Merauke
                                </span>
                                <h1 class="text-5xl md:text-7xl lg:text-8xl font-heading font-bold text-white mb-6 leading-tight drop-shadow-2xl">
                                    Experience Comfort <br> <span class="text-brand-secondary">in The East</span>
                                </h1>
                                <a href="#rooms" class="inline-block bg-brand-secondary hover:bg-white hover:text-brand-primary text-white font-bold py-4 px-10 rounded-full transition-all duration-300 shadow-lg shadow-brand-secondary/30 mt-8">
                                    Jelajahi Kamar
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next text-white/50 hover:text-white transition-colors"></div>
            <div class="swiper-button-prev text-white/50 hover:text-white transition-colors"></div>
        </div>
    </div>

    {{-- 2. BOOKING WIDGET (Floating Glass Blue) --}}
    <div class="relative z-30 -mt-24 px-4 sm:px-6 lg:px-8 mb-20">
        <div class="max-w-6xl mx-auto bg-white/80 backdrop-blur-xl border border-white/40 rounded-3xl shadow-2xl p-6 md:p-8 relative overflow-hidden">
            {{-- Decorative gradient blob --}}
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-brand-secondary/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <form action="{{ route('rooms.availability') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end relative z-10">
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-brand-primary uppercase tracking-wide mb-2">Check In</label>
                    <div class="relative group">
                        <input type="text" class="datepicker w-full bg-brand-light border-transparent text-brand-dark text-sm rounded-xl focus:ring-2 focus:ring-brand-secondary focus:bg-white block p-4 pl-12 font-medium transition-all group-hover:bg-white shadow-sm" id="checkin" name="checkin" required placeholder="Select Date">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <i class="far fa-calendar text-brand-secondary text-lg"></i>
                        </div>
                    </div>
                </div>
                
                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-brand-primary uppercase tracking-wide mb-2">Check Out</label>
                    <div class="relative group">
                        <input type="text" class="datepicker w-full bg-brand-light border-transparent text-brand-dark text-sm rounded-xl focus:ring-2 focus:ring-brand-secondary focus:bg-white block p-4 pl-12 font-medium transition-all group-hover:bg-white shadow-sm" id="checkout" name="checkout" required placeholder="Select Date">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <i class="far fa-calendar text-brand-secondary text-lg"></i>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-xs font-bold text-brand-primary uppercase tracking-wide mb-2">Guests</label>
                    <div class="relative group">
                        <select name="guests" class="w-full bg-brand-light border-transparent text-brand-dark text-sm rounded-xl focus:ring-2 focus:ring-brand-secondary focus:bg-white block p-4 pl-12 appearance-none font-medium transition-all group-hover:bg-white shadow-sm">
                            <option value="1">1 Guest</option>
                            <option value="2" selected>2 Guests</option>
                            <option value="3">3 Guests</option>
                            <option value="4">4+ Guests</option>
                        </select>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <i class="fas fa-user-friends text-brand-secondary text-lg"></i>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                            <i class="fas fa-chevron-down text-brand-primary/50 text-sm"></i>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1">
                    <button type="submit" class="w-full bg-brand-primary hover:bg-brand-secondary text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-lg shadow-brand-primary/30 group">
                        <span>Check Availability</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. INTRO SECTION --}}
    <section class="py-20 bg-brand-light relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <div class="relative group">
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-brand-secondary/20 rounded-full blur-xl group-hover:bg-brand-secondary/40 transition-all"></div>
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1000&auto=format&fit=crop" alt="Resort Vibe" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover h-[500px] transform transition-transform duration-700 hover:scale-[1.02]">
                        <div class="absolute -bottom-6 -right-6 w-48 h-48 bg-brand-primary/10 rounded-full blur-2xl z-0"></div>
                        
                        {{-- Floating Badge --}}
                        <div class="absolute bottom-8 right-8 bg-white/90 backdrop-blur-sm p-6 rounded-2xl shadow-xl z-20 max-w-xs hidden md:block border border-white/50">
                            <div class="flex items-center gap-4 mb-2">
                                <div class="w-12 h-12 bg-brand-secondary/10 rounded-full flex items-center justify-center text-brand-secondary">
                                    <i class="fas fa-water text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-brand-primary">Ocean Breeze</p>
                                    <p class="text-xs text-gray-500">Relax by the pool</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <span class="text-brand-secondary font-bold uppercase tracking-widest text-sm">About Us</span>
                    <h2 class="text-4xl md:text-5xl font-heading font-bold text-brand-primary mt-4 mb-6 leading-tight">
                        A Sanctuary of <br> <span class="text-brand-secondary">Serenity & Style</span>
                    </h2>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        Terletak strategis di jantung Merauke, Sora Hotel menawarkan perpaduan sempurna antara kemewahan modern dan kehangatan budaya lokal. Kami menghadirkan pengalaman menginap yang tak terlupakan dengan nuansa biru yang menenangkan.
                    </p>
                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-brand-secondary/10 flex items-center justify-center text-brand-secondary">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span class="font-medium text-gray-700">Lokasi Strategis di Pusat Kota</span>
                        </li>
                        <li class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-brand-secondary/10 flex items-center justify-center text-brand-secondary">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <span class="font-medium text-gray-700">Fasilitas MICE Terlengkap</span>
                        </li>
                        <li class="flex items-center gap-4 p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                            <div class="w-10 h-10 rounded-full bg-brand-secondary/10 flex items-center justify-center text-brand-secondary">
                                <i class="fas fa-concierge-bell"></i>
                            </div>
                            <span class="font-medium text-gray-700">Pelayanan Ramah & Profesional</span>
                        </li>
                    </ul>
                    <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 text-brand-primary font-bold hover:text-brand-secondary transition-colors group">
                        Learn More About Us <i class="fas fa-long-arrow-alt-right transform group-hover:translate-x-2 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. ACCOMMODATION (Swiper) --}}
    <section id="rooms" class="py-24 bg-white relative">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-brand-secondary font-bold uppercase tracking-widest text-sm">Accommodation</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold text-brand-primary mt-2 mb-4">Stay in Luxury</h2>
                <p class="text-gray-500">Temukan kenyamanan istirahat Anda di kamar-kamar kami yang dirancang elegan dengan sentuhan modern.</p>
            </div>

            <div class="swiper rooms-swiper pb-12 !overflow-visible">
                <div class="swiper-wrapper">
                    @if(isset($rooms) && $rooms->count() > 0)
                        @foreach($rooms as $room)
                            <div class="swiper-slide">
                                <div class="group bg-white rounded-[2rem] shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 h-full flex flex-col transform hover:-translate-y-2">
                                    <div class="relative h-72 overflow-hidden">
                                        <img src="{{ $room->image ? asset('storage/' . $room->image) : ($room->images->first() ? asset('storage/' . $room->images->first()->path) : 'https://placehold.co/600x400') }}" 
                                             alt="{{ $room->name }}" 
                                             class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-full text-xs font-bold text-brand-primary shadow-sm">
                                            {{ $room->type ?? 'Premium' }}
                                        </div>
                                    </div>
                                    <div class="p-8 flex flex-col flex-grow">
                                        <h3 class="text-2xl font-heading font-bold text-brand-dark mb-3 group-hover:text-brand-secondary transition-colors">
                                            {{ $room->name }}
                                        </h3>
                                        <p class="text-gray-500 text-sm mb-6 line-clamp-2 flex-grow">
                                            {{ $room->description }}
                                        </p>
                                        <div class="flex items-end justify-between mt-auto pt-6 border-t border-gray-100">
                                            <div>
                                                <span class="text-xs text-gray-400 uppercase tracking-wide">Start From</span>
                                                <div class="text-xl font-bold text-brand-primary">
                                                    Rp {{ number_format($room->price, 0, ',', '.') }}
                                                    <span class="text-xs text-gray-400 font-normal">/ night</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('rooms.show', $room->slug ?? $room->id) }}" class="w-12 h-12 rounded-full bg-brand-light text-brand-primary flex items-center justify-center hover:bg-brand-primary hover:text-white transition-all shadow-md">
                                                <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center w-full py-10 text-gray-500">No rooms available at the moment.</div>
                    @endif
                </div>
                <div class="swiper-pagination"></div>
            </div>
            
            <div class="text-center mt-8">
                <a href="{{ route('rooms.index') }}" class="inline-block border-2 border-brand-primary text-brand-primary hover:bg-brand-primary hover:text-white font-bold py-3 px-10 rounded-full transition-all duration-300">
                    View All Rooms
                </a>
            </div>
        </div>
    </section>

    {{-- 5. MICE & EVENTS (Detailed) --}}
    <section class="py-24 bg-brand-primary text-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 40px 40px;"></div>
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-secondary/20 to-transparent"></div>
        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row gap-16">
                <div class="lg:w-1/3">
                    <span class="text-brand-secondary font-bold uppercase tracking-widest text-sm">Business & Events</span>
                    <h2 class="text-4xl md:text-5xl font-heading font-bold mt-4 mb-6">MICE Facilities</h2>
                    <p class="text-blue-100 leading-relaxed mb-8">
                        Sora Hotel menyediakan fasilitas meeting dan ballroom berkelas untuk menunjang kesuksesan acara bisnis maupun sosial Anda. Dilengkapi dengan teknologi audio-visual terkini.
                    </p>
                    
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-brand-secondary flex-shrink-0 border border-white/10">
                                <i class="fas fa-microphone-alt text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">Modern Equipment</h4>
                                <p class="text-sm text-blue-200">Sound system, proyektor, dan layar LED berkualitas tinggi.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-brand-secondary flex-shrink-0 border border-white/10">
                                <i class="fas fa-utensils text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">Premium Catering</h4>
                                <p class="text-sm text-blue-200">Pilihan menu buffet dan coffee break yang variatif dan lezat.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center text-brand-secondary flex-shrink-0 border border-white/10">
                                <i class="fas fa-wifi text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg">High-Speed WiFi</h4>
                                <p class="text-sm text-blue-200">Koneksi internet cepat dan stabil untuk seluruh peserta.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('mice.index') }}" class="inline-block bg-brand-secondary hover:bg-white hover:text-brand-primary text-white font-bold py-3 px-8 rounded-lg transition-all shadow-lg shadow-brand-secondary/30">
                            Explore MICE Packages
                        </a>
                    </div>
                </div>

                <div class="lg:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(isset($miceRooms) && $miceRooms->count() > 0)
                            @foreach($miceRooms as $mice)
                                <div class="group relative overflow-hidden rounded-2xl aspect-[4/3] bg-brand-dark">
                                    <img src="{{ $mice->image ? asset('storage/' . $mice->image) : ($mice->images->first() ? asset('storage/' . $mice->images->first()->path) : 'https://placehold.co/600x400') }}" 
                                         alt="{{ $mice->name }}" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110 opacity-80 group-hover:opacity-100">
                                    <div class="absolute inset-0 bg-gradient-to-t from-brand-primary/90 via-transparent to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-6 w-full">
                                        <h3 class="text-xl font-bold text-white mb-1">{{ $mice->name }}</h3>
                                        <div class="flex items-center justify-between">
                                            <span class="text-brand-secondary text-sm font-medium"><i class="fas fa-users mr-2"></i> {{ $mice->capacity ?? 'Up to 100' }} Pax</span>
                                            <a href="{{ route('mice.show', $mice->slug ?? $mice->id) }}" class="text-white text-sm hover:text-brand-secondary transition-colors">Details <i class="fas fa-arrow-right ml-1"></i></a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                             <div class="col-span-2 flex items-center justify-center h-64 bg-white/5 rounded-2xl border border-white/10">
                                <p class="text-blue-200">MICE information coming soon.</p>
                             </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. DINING & RECREATION (New Section) --}}
    @if((isset($restaurants) && $restaurants->count() > 0) || (isset($recreationAreas) && $recreationAreas->count() > 0))
    <section class="py-24 bg-brand-light">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-brand-secondary font-bold uppercase tracking-widest text-sm">Facilities</span>
                <h2 class="text-4xl md:text-5xl font-heading font-bold text-brand-primary mt-2 mb-4">Dining & Recreation</h2>
                <p class="text-gray-500">Nikmati ragam kuliner lezat dan fasilitas rekreasi untuk menyempurnakan pengalaman Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                {{-- Dining --}}
                @if(isset($restaurants) && $restaurants->count() > 0)
                <div>
                    <h3 class="text-2xl font-bold text-brand-primary mb-6 flex items-center gap-3">
                        <i class="fas fa-utensils text-brand-secondary"></i> Culinary Delights
                    </h3>
                    <div class="space-y-6">
                        @foreach($restaurants as $restaurant)
                            <div class="flex gap-4 bg-white p-4 rounded-2xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                                <div class="w-24 h-24 rounded-xl overflow-hidden flex-shrink-0">
                                    <img src="{{ $restaurant->image_path ? asset('storage/' . $restaurant->image_path) : ($restaurant->images->first() ? asset('storage/' . $restaurant->images->first()->path) : 'https://placehold.co/150') }}" 
                                         class="w-full h-full object-cover" alt="{{ $restaurant->name }}">
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg text-gray-900">{{ $restaurant->name }}</h4>
                                    <p class="text-sm text-gray-500 line-clamp-2 mb-2">{{ $restaurant->description }}</p>
                                    <a href="{{ route('restaurants.show', $restaurant->slug ?? $restaurant->id) }}" class="text-sm text-brand-primary font-bold hover:text-brand-secondary transition-colors">View Menu</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Recreation --}}
                @if(isset($recreationAreas) && $recreationAreas->count() > 0)
                <div>
                    <h3 class="text-2xl font-bold text-brand-primary mb-6 flex items-center gap-3">
                        <i class="fas fa-swimming-pool text-brand-secondary"></i> Relax & Unwind
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($recreationAreas as $area)
                            <div class="group relative overflow-hidden rounded-2xl aspect-square shadow-md">
                                <img src="{{ $area->image_path ? asset('storage/' . $area->image_path) : ($area->images->first() ? asset('storage/' . $area->images->first()->path) : 'https://placehold.co/400') }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="{{ $area->name }}">
                                <div class="absolute inset-0 bg-gradient-to-t from-brand-primary/80 to-transparent opacity-90"></div>
                                <div class="absolute bottom-0 left-0 p-4">
                                    <h4 class="text-white font-bold text-lg">{{ $area->name }}</h4>
                                    <p class="text-blue-100 text-xs line-clamp-1">{{ $area->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- 7. CTA SECTION --}}
    <section class="py-24 bg-brand-secondary relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
             <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/20 rounded-full blur-3xl"></div>
             <div class="absolute bottom-0 right-0 w-96 h-96 bg-brand-primary/20 rounded-full blur-3xl"></div>
        </div>
        
        <div class="container mx-auto px-4 text-center relative z-10">
            <h2 class="text-4xl md:text-5xl font-heading font-bold text-white mb-6">Ready to Experience Paradise?</h2>
            <p class="text-white/90 text-xl max-w-2xl mx-auto mb-10 font-medium">
                Book your stay at Sora Hotel Merauke today and enjoy exclusive offers.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('rooms.index') }}" class="bg-white text-brand-primary hover:bg-brand-primary hover:text-white font-bold py-4 px-10 rounded-full shadow-xl transition-all transform hover:-translate-y-1">
                    Book Now
                </a>
                <a href="{{ route('contact.index') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-brand-primary font-bold py-4 px-10 rounded-full transition-all">
                    Contact Us
                </a>
            </div>
        </div>
    </section>

    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Hero Swiper
            new Swiper('.hero-swiper', {
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });

            // Rooms Swiper
            new Swiper('.rooms-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 4000,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
        });
    </script>

    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fade-in-up 1s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.2s; }
        .delay-200 { animation-delay: 0.4s; }
        .delay-300 { animation-delay: 0.6s; }
        
        /* Custom Swiper Styles */
        .swiper-button-next, .swiper-button-prev { color: #ffffff; }
        .swiper-pagination-bullet-active { background: #0ea5e9; }
    </style>
@endsection

