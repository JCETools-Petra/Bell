<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(isset($settings['favicon_path']))
        <link rel="icon" href="{{ asset('storage/' . $settings['favicon_path']) }}" type="image/x-icon">
    @endif
    
    <title>@yield('seo_title', $settings['website_title'] ?? 'Sora Hotel Merauke')</title>
    <meta name="description" content="@yield('meta_description', 'Sora Hotel Merauke adalah hotel modern yang berlokasi strategis di pusat Kota Merauke.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        .font-heading { family: 'Playfair Display', serif; }
        .font-body { family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="font-body text-gray-700 antialiased bg-brand-light flex flex-col min-h-screen">

    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'bg-brand-primary/90 backdrop-blur-md shadow-lg border-b border-white/10': scrolled, 'bg-transparent border-transparent': !scrolled && '{{ request()->routeIs('home') }}', 'bg-brand-primary shadow-md': !'{{ request()->routeIs('home') }}' }"
         class="fixed w-full z-50 transition-all duration-300 top-0 start-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                
                {{-- Logo Container --}}
                <div class="flex-shrink-0 relative z-10">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        
                        {{-- 1. Logo Image (Selalu muncul jika ada) --}}
                        @if(isset($settings['logo_path']) && $settings['logo_path'])
                            <img src="{{ asset('storage/' . $settings['logo_path']) }}" class="h-14 w-auto object-contain drop-shadow-md transition-transform transform group-hover:scale-105" alt="Logo">
                        @endif

                        {{-- 2. Logo Text (Muncul jika Logo Kosong ATAU Setting 'show_logo_text' Aktif) --}}
                        @if( empty($settings['logo_path']) || (isset($settings['show_logo_text']) && $settings['show_logo_text'] == '1') )
                            <div class="flex flex-col">
                                <span class="text-2xl font-heading font-bold text-white tracking-widest group-hover:text-brand-accent transition-colors drop-shadow-sm leading-none">
                                    {{ $settings['website_title'] ?? 'SORA' }}
                                </span>
                                <span class="text-xs text-brand-secondary tracking-[0.3em] uppercase font-medium mt-1">
                                    Hotel Merauke
                                </span>
                            </div>
                        @endif

                    </a>
                </div>

                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-8">
                        <a href="{{ route('home') }}" class="text-sm font-medium transition-colors relative group {{ request()->routeIs('home') ? 'text-white' : 'text-gray-200 hover:text-white' }}">
                            Home
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-accent transition-all duration-300 group-hover:w-full {{ request()->routeIs('home') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('rooms.index') }}" class="text-sm font-medium transition-colors relative group {{ request()->routeIs('rooms.*') ? 'text-white' : 'text-gray-200 hover:text-white' }}">
                            Accommodation
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-accent transition-all duration-300 group-hover:w-full {{ request()->routeIs('rooms.*') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('mice.index') }}" class="text-sm font-medium transition-colors relative group {{ request()->routeIs('mice.*') ? 'text-white' : 'text-gray-200 hover:text-white' }}">
                            MICE
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-accent transition-all duration-300 group-hover:w-full {{ request()->routeIs('mice.*') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('restaurants.index') }}" class="text-sm font-medium transition-colors relative group {{ request()->routeIs('restaurants.*') ? 'text-white' : 'text-gray-200 hover:text-white' }}">
                            Dining
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-accent transition-all duration-300 group-hover:w-full {{ request()->routeIs('restaurants.*') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('recreation-areas.index') }}" class="text-sm font-medium transition-colors relative group {{ request()->routeIs('recreation-areas.*') ? 'text-white' : 'text-gray-200 hover:text-white' }}">
                            Recreation
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-accent transition-all duration-300 group-hover:w-full {{ request()->routeIs('recreation-areas.*') ? 'w-full' : '' }}"></span>
                        </a>
                        <a href="{{ route('contact.index') }}" class="text-sm font-medium transition-colors relative group {{ request()->routeIs('contact.index') ? 'text-white' : 'text-gray-200 hover:text-white' }}">
                            Contact
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-brand-accent transition-all duration-300 group-hover:w-full {{ request()->routeIs('contact.index') ? 'w-full' : '' }}"></span>
                        </a>
                    </div>
                </div>

                <div class="hidden md:block">
                    <div class="flex items-center gap-4">
                        @auth
                            @if(Auth::user()->affiliate && Auth::user()->affiliate->status == 'active')
                                <a href="{{ route('affiliate.dashboard') }}" class="text-sm font-medium text-white hover:text-brand-accent transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-white hover:text-brand-accent transition-colors">Dashboard</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-brand-accent transition-colors">Partner Login</a>
                            <a href="{{ route('rooms.index') }}" class="bg-brand-secondary hover:bg-white hover:text-brand-primary text-white px-6 py-2.5 rounded-full text-sm font-bold transition-all shadow-lg hover:shadow-brand-secondary/50 transform hover:-translate-y-0.5">
                                Book Now
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="-mr-2 flex md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none transition-colors">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg class="h-6 w-6" :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-brand-primary border-t border-white/10">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-white hover:bg-white/10 {{ request()->routeIs('home') ? 'bg-white/10 text-brand-accent' : '' }}">Home</a>
                <a href="{{ route('rooms.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-200 hover:text-white hover:bg-white/10">Accommodation</a>
                <a href="{{ route('mice.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-200 hover:text-white hover:bg-white/10">MICE</a>
                <a href="{{ route('restaurants.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-200 hover:text-white hover:bg-white/10">Dining</a>
                <a href="{{ route('recreation-areas.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-200 hover:text-white hover:bg-white/10">Recreation</a>
                <a href="{{ route('contact.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-200 hover:text-white hover:bg-white/10">Contact</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-brand-accent hover:bg-white/10">My Dashboard</a>
                @else
                    <div class="pt-4 mt-4 border-t border-white/10">
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-200 hover:text-white">Login</a>
                        <a href="{{ route('rooms.index') }}" class="block w-full text-center mt-2 bg-brand-secondary text-white px-3 py-3 rounded-lg font-bold">Book Now</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-brand-dark text-white pt-20 pb-10 border-t border-white/5 relative overflow-hidden">
        {{-- ... (kode footer Anda tidak berubah) ... --}}
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-primary via-brand-secondary to-brand-primary"></div>
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-brand-primary/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div>
                    <h3 class="text-3xl font-heading font-bold text-white mb-6 tracking-wide">SORA <span class="text-brand-secondary">HOTEL</span></h3>
                    <p class="text-gray-400 text-sm leading-relaxed mb-8">
                        Experience the perfect blend of luxury and local culture in the heart of Merauke. Your sanctuary of comfort awaits.
                    </p>
                    <div class="flex space-x-4">
                        @if(!empty($settings['contact_facebook']))
                            <a href="{{ $settings['contact_facebook'] }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-brand-primary hover:text-white transition-all"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($settings['contact_instagram']))
                            <a href="{{ $settings['contact_instagram'] }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-brand-primary hover:text-white transition-all"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(!empty($settings['contact_phone']))
                            <a href="https://wa.me/{{ $settings['contact_phone'] }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-400 hover:bg-brand-primary hover:text-white transition-all"><i class="fab fa-whatsapp"></i></a>
                        @endif
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 text-white">Explore</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="{{ route('home') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Home</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Accommodation</a></li>
                        <li><a href="{{ route('mice.index') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Meeting & Events</a></li>
                        <li><a href="{{ route('restaurants.index') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Dining</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 text-white">Information</h4>
                    <ul class="space-y-3 text-sm text-gray-400">
                        <li><a href="{{ route('contact.index') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Contact Us</a></li>
                        <li><a href="{{ route('pages.terms') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Terms & Conditions</a></li>
                        <li><a href="{{ route('pages.affiliate_info') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Affiliate Program</a></li>
                        <li><a href="{{ route('affiliate.register.create') }}" class="hover:text-brand-secondary transition-colors flex items-center gap-2"><i class="fas fa-chevron-right text-xs opacity-50"></i> Partner Registration</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-6 text-white">Contact</h4>
                    <ul class="space-y-5 text-sm text-gray-400">
                        <li class="flex items-start gap-4">
                            <div class="w-8 h-8 rounded bg-brand-primary/20 flex items-center justify-center text-brand-secondary flex-shrink-0 mt-1">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <span>{{ $settings['contact_address'] ?? 'Jl. Raya Mandala No. 123, Merauke, Papua Selatan' }}</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded bg-brand-primary/20 flex items-center justify-center text-brand-secondary flex-shrink-0">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <span>{{ $settings['contact_phone'] ?? '+62 812 3456 7890' }}</span>
                        </li>
                        <li class="flex items-center gap-4">
                            <div class="w-8 h-8 rounded bg-brand-primary/20 flex items-center justify-center text-brand-secondary flex-shrink-0">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <span>{{ $settings['contact_email'] ?? 'info@sorahotelmerauke.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} <span class="text-white font-medium">{{ $settings['website_title'] ?? 'Sora Hotel' }}</span>. All rights reserved.
                </p>
                <div class="flex gap-6">
                    <span class="text-gray-600 text-xs">Privacy Policy</span>
                    <span class="text-gray-600 text-xs">Cookie Policy</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="//unpkg.com/alpinejs" defer></script> 
    
    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const fpConfig = {
            dateFormat: "d-m-Y",
            minDate: "today"
        };
        flatpickr(".datepicker", fpConfig);
        
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(function(input) {
            // flatpickr(input, fpConfig); 
        });
    });
    </script>
</body>
</html>