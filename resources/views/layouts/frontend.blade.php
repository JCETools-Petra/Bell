<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    @if(isset($settings['favicon_path']))
        <link rel="icon" href="{{ asset('storage/' . $settings['favicon_path']) }}" type="image/x-icon">
    @endif
    
    <title>@yield('seo_title', $settings['website_title'] ?? 'Bell Hotel Merauke')</title>
    <meta name="description" content="@yield('meta_description', 'Bell Hotel Merauke adalah hotel modern yang berlokasi strategis di pusat Kota Merauke.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700;800&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}?v={{ filemtime(public_path('css/custom-style.css')) }}">

    {{-- Style untuk kalender Flatpickr --}}
    {{-- Style untuk kalender Flatpickr sudah dipindahkan ke custom-style.css --}}
    @stack('styles')
</head>
<body class="{{ request()->routeIs('home') || request()->routeIs('rooms.index') || request()->routeIs('contact.index') || request()->routeIs('mice.index') || request()->routeIs('restaurants.index') || request()->routeIs('restaurants.show') ? 'homepage' : '' }}">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" data-bs-theme="dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                @if(isset($settings['logo_path']) && $settings['logo_path'])
                    <img src="{{ asset('storage/' . $settings['logo_path']) }}"
                         alt="{{ $settings['website_title'] ?? 'Logo' }}"
                         class="highlighted-logo"
                         style="height: {{ $settings['logo_height'] ?? '40' }}px; width: auto; margin-right: 10px;">
                @endif
                @if( ($settings['show_logo_text'] ?? '1') == '1' )
                    <span class="d-none d-lg-inline">{{ $settings['website_title'] ?? 'Bell Hotel' }}</span>
                @endif
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('mice.*') ? 'active' : '' }}" href="{{ route('mice.index') }}">Mice</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('restaurants.*') ? 'active' : '' }}" href="{{ route('restaurants.index') }}">Restaurants</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link {{ request()->routeIs('recreation-areas.*') ? 'active' : '' }}" href="{{ route('recreation-areas.index') }}">Recreation Area</a>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact.index') ? 'active' : '' }}" href="{{ route('contact.index') }}">Contact Us</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('pages.affiliate_info') || request()->routeIs('affiliate.register.create') ? 'active' : '' }}" href="#" id="navbarDropdownAffiliate" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Affiliate Program
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownAffiliate">
                            <li><a class="dropdown-item" href="{{ route('pages.affiliate_info') }}">Apa itu Affiliate?</a></li>
                            <li><a class="dropdown-item" href="{{ route('affiliate.register.create') }}">Daftar Affiliate</a></li>
                        </ul>
                    </li>
                    @auth
                        @if(Auth::user()->affiliate && Auth::user()->affiliate->status == 'active')
                             <li class="nav-item">
                                <a class="nav-link" href="{{ route('affiliate.dashboard') }}">Affiliate Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();"
                                       class="nav-link">
                                        Logout
                                    </a>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                        @endif
                    @else
                         <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    @if(isset($settings['running_text_enabled']) && $settings['running_text_enabled'] == '1' && !empty($settings['running_text_content']))
    <div class="running-text-container">
        @if(!empty($settings['running_text_url']))
            <a href="{{ $settings['running_text_url'] }}" class="running-text-link" target="_blank" rel="noopener">
                <p class="running-text-content">{{ $settings['running_text_content'] }}</p>
            </a>
        @else
            <p class="running-text-content">{{ $settings['running_text_content'] }}</p>
        @endif
    </div>
    @endif

    <main>
        @yield('content')
    </main>
    <footer class="footer mt-auto" style="background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 50%, #87ceeb 100%); position: relative; overflow: hidden;">
        <!-- Decorative Wave Pattern -->
        <div style="position: absolute; top: 0; left: 0; right: 0; height: 80px; background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 1200 120%22 preserveAspectRatio=%22none%22><path d=%22M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z%22 fill=%22%23ffffff%22 opacity=%220.1%22/></svg>') no-repeat; background-size: cover;"></div>

        <div class="container position-relative" style="padding-top: 5rem; padding-bottom: 2rem;">
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-4">
                        @if(isset($settings['logo_path']) && $settings['logo_path'])
                            <img src="{{ asset('storage/' . $settings['logo_path']) }}"
                                 alt="{{ $settings['website_title'] ?? 'Logo' }}"
                                 style="height: 50px; width: auto; filter: brightness(0) invert(1);">
                        @else
                            <div class="p-3 rounded-3 me-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                                <i class="fas fa-hotel" style="font-size: 2rem; color: #FFE4B5;"></i>
                            </div>
                        @endif
                        <h3 class="h4 text-white fw-bold mb-0 ms-3">{{ $settings['website_title'] ?? 'Bell Hotel Merauke' }}</h3>
                    </div>
                    <p class="text-white-50 mb-4" style="line-height: 1.8;">
                        Pengalaman menginap terbaik di Merauke dengan fasilitas modern, pelayanan prima, dan suasana yang nyaman seperti di rumah sendiri.
                    </p>
                    <div class="d-flex gap-2">
                        @if(!empty($settings['contact_facebook']))
                        <a href="{{ $settings['contact_facebook'] }}" target="_blank" rel="noopener"
                           class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                           style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;"
                           onmouseover="this.style.background='#FFE4B5'; this.style.borderColor='#FFE4B5';"
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        @endif
                        @if(!empty($settings['contact_instagram']))
                        <a href="{{ $settings['contact_instagram'] }}" target="_blank" rel="noopener"
                           class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                           style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;"
                           onmouseover="this.style.background='#FFE4B5'; this.style.borderColor='#FFE4B5';"
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        @endif
                        @if(!empty($settings['contact_phone']))
                        @php
                            $phone = $settings['contact_phone'];
                            $cleanedPhone = preg_replace('/[^0-9]/', '', $phone);
                            $waPhone = substr($cleanedPhone, 0, 1) === '0'
                                ? '62' . substr($cleanedPhone, 1)
                                : $cleanedPhone;
                        @endphp
                        <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener"
                           class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                           style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;"
                           onmouseover="this.style.background='#FFE4B5'; this.style.borderColor='#FFE4B5';"
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                            <i class="fab fa-whatsapp text-white"></i>
                        </a>
                        @endif
                        @if(!empty($settings['contact_youtube']))
                        <a href="{{ $settings['contact_youtube'] }}" target="_blank" rel="noopener"
                           class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                           style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;"
                           onmouseover="this.style.background='#FFE4B5'; this.style.borderColor='#FFE4B5';"
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                        @endif
                        @if(!empty($settings['contact_tiktok']))
                        <a href="{{ $settings['contact_tiktok'] }}" target="_blank" rel="noopener"
                           class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center"
                           style="width: 40px; height: 40px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2); transition: all 0.3s;"
                           onmouseover="this.style.background='#FFE4B5'; this.style.borderColor='#FFE4B5';"
                           onmouseout="this.style.background='rgba(255,255,255,0.1)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                            <i class="fab fa-tiktok text-white"></i>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="d-flex align-items-center mb-4">
                        <div class="p-2 rounded-3 me-2" style="background: linear-gradient(135deg, #FFE4B5 0%, #f4d9a6 100%);">
                            <i class="fas fa-link" style="font-size: 1.2rem; color: #1e3a5f;"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Quick Links</h5>
                    </div>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> Home
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('rooms.index') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> Rooms
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('mice.index') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> MICE
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('restaurants.index') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> Restaurants
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('contact.index') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> Contact Us
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Programs -->
                <div class="col-lg-2 col-md-6">
                    <div class="d-flex align-items-center mb-4">
                        <div class="p-2 rounded-3 me-2" style="background: linear-gradient(135deg, #FFE4B5 0%, #f4d9a6 100%);">
                            <i class="fas fa-handshake" style="font-size: 1.2rem; color: #1e3a5f;"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Programs</h5>
                    </div>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('pages.affiliate_info') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> About Affiliate
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('affiliate.register.create') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> Register Affiliate
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('pages.terms') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                               style="transition: all 0.3s;"
                               onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                               onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> Terms & Conditions
                            </a>
                        </li>
                        @auth
                            @if(Auth::user()->affiliate && Auth::user()->affiliate->status == 'active')
                            <li class="mb-2">
                                <a href="{{ route('affiliate.dashboard') }}" class="text-white-50 text-decoration-none d-flex align-items-center"
                                   style="transition: all 0.3s;"
                                   onmouseover="this.style.color='#FFE4B5'; this.style.paddingLeft='8px';"
                                   onmouseout="this.style.color='rgba(255,255,255,0.5)'; this.style.paddingLeft='0';">
                                    <i class="fas fa-chevron-right me-2" style="font-size: 0.7rem;"></i> Affiliate Dashboard
                                </a>
                            </li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="d-flex align-items-center mb-4">
                        <div class="p-2 rounded-3 me-2" style="background: linear-gradient(135deg, #FFE4B5 0%, #f4d9a6 100%);">
                            <i class="fas fa-address-book" style="font-size: 1.2rem; color: #1e3a5f;"></i>
                        </div>
                        <h5 class="text-white fw-bold mb-0">Contact Info</h5>
                    </div>
                    <ul class="list-unstyled">
                        @if(!empty($settings['contact_address']))
                        <li class="mb-3 d-flex align-items-start">
                            <div class="p-2 rounded me-3" style="background: rgba(255,255,255,0.1); min-width: 40px; text-align: center;">
                                <i class="fas fa-map-marker-alt text-white"></i>
                            </div>
                            <div>
                                <small class="text-white-50 d-block mb-1">Address</small>
                                <p class="text-white mb-0" style="line-height: 1.6;">{{ $settings['contact_address'] }}</p>
                            </div>
                        </li>
                        @endif
                        @if(!empty($settings['contact_phone']))
                        <li class="mb-3 d-flex align-items-start">
                            <div class="p-2 rounded me-3" style="background: rgba(255,255,255,0.1); min-width: 40px; text-align: center;">
                                <i class="fas fa-phone-alt text-white"></i>
                            </div>
                            <div>
                                <small class="text-white-50 d-block mb-1">Phone</small>
                                <a href="tel:{{ $settings['contact_phone'] }}" class="text-white text-decoration-none"
                                   style="transition: color 0.3s;"
                                   onmouseover="this.style.color='#FFE4B5';"
                                   onmouseout="this.style.color='white';">
                                    {{ $settings['contact_phone'] }}
                                </a>
                            </div>
                        </li>
                        @endif
                        @if(!empty($settings['contact_email']))
                        <li class="mb-3 d-flex align-items-start">
                            <div class="p-2 rounded me-3" style="background: rgba(255,255,255,0.1); min-width: 40px; text-align: center;">
                                <i class="fas fa-envelope text-white"></i>
                            </div>
                            <div>
                                <small class="text-white-50 d-block mb-1">Email</small>
                                <a href="mailto:{{ $settings['contact_email'] }}" class="text-white text-decoration-none"
                                   style="transition: color 0.3s;"
                                   onmouseover="this.style.color='#FFE4B5';"
                                   onmouseout="this.style.color='white';">
                                    {{ $settings['contact_email'] }}
                                </a>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="row mt-5 pt-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="text-white-50 mb-0">
                        <i class="far fa-copyright me-1"></i> {{ date('Y') }} {{ $settings['website_title'] ?? 'Bell Hotel Merauke' }}. All Rights Reserved.
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="text-white-50 mb-0">
                        <i class="fas fa-heart" style="color: #FFE4B5;"></i> Designed with passion for hospitality excellence
                    </p>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <a href="#" class="btn btn-lg rounded-circle position-fixed bottom-0 end-0 mb-4 me-4 d-none" id="backToTop"
           style="width: 55px; height: 55px; background: linear-gradient(135deg, #FFE4B5 0%, #f4d9a6 100%); border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.3); z-index: 999; display: flex !important; align-items: center; justify-content: center;"
           onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 6px 20px rgba(0,0,0,0.4)';"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.3)';">
            <i class="fas fa-arrow-up" style="color: #1e3a5f; font-size: 1.2rem;"></i>
        </a>

        <script>
            // Back to Top functionality
            window.addEventListener('scroll', function() {
                const backToTop = document.getElementById('backToTop');
                if (window.scrollY > 300) {
                    backToTop.classList.remove('d-none');
                } else {
                    backToTop.classList.add('d-none');
                }
            });

            document.getElementById('backToTop').addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        </script>
    </footer>
    <!-- Modern Floating Social Media Bar -->
    <div class="modern-floating-social" style="position: fixed; left: 0; top: 50%; transform: translateY(-50%); z-index: 1000;">
        <div style="display: flex; flex-direction: column; gap: 12px; padding: 16px 12px; background: linear-gradient(135deg, rgba(30, 58, 95, 0.95) 0%, rgba(44, 95, 141, 0.95) 50%, rgba(135, 206, 235, 0.95) 100%); backdrop-filter: blur(20px); border-radius: 0 24px 24px 0; box-shadow: 4px 0 30px rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.15); border-left: none;">

            @if(!empty($settings['contact_facebook']))
            <a href="{{ $settings['contact_facebook'] }}" target="_blank" rel="noopener"
               class="social-btn" data-social="Facebook"
               style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #1877f2 0%, #0d5dbf 100%); border-radius: 14px; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3); border: 2px solid rgba(255,255,255,0.2);"
               onmouseover="this.style.transform='translateX(8px) scale(1.1)'; this.style.boxShadow='0 8px 25px rgba(24, 119, 242, 0.5)'; this.style.borderColor='rgba(255,255,255,0.4)';"
               onmouseout="this.style.transform='translateX(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(24, 119, 242, 0.3)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                <i class="fab fa-facebook-f" style="color: white; font-size: 1.4rem;"></i>
                <span class="social-tooltip" style="position: absolute; left: 70px; background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 100%); color: white; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">Facebook</span>
            </a>
            @endif

            @if(!empty($settings['contact_instagram']))
            <a href="{{ $settings['contact_instagram'] }}" target="_blank" rel="noopener"
               class="social-btn" data-social="Instagram"
               style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); border-radius: 14px; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; box-shadow: 0 4px 15px rgba(225, 48, 108, 0.3); border: 2px solid rgba(255,255,255,0.2);"
               onmouseover="this.style.transform='translateX(8px) scale(1.1)'; this.style.boxShadow='0 8px 25px rgba(225, 48, 108, 0.5)'; this.style.borderColor='rgba(255,255,255,0.4)';"
               onmouseout="this.style.transform='translateX(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(225, 48, 108, 0.3)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                <i class="fab fa-instagram" style="color: white; font-size: 1.5rem;"></i>
                <span class="social-tooltip" style="position: absolute; left: 70px; background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 100%); color: white; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">Instagram</span>
            </a>
            @endif

            @if(!empty($settings['contact_phone']))
            @php
                $phone = $settings['contact_phone'];
                $cleanedPhone = preg_replace('/[^0-9]/', '', $phone);
                $waPhone = substr($cleanedPhone, 0, 1) === '0'
                    ? '62' . substr($cleanedPhone, 1)
                    : $cleanedPhone;
            @endphp
            <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener"
               class="social-btn" data-social="WhatsApp"
               style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #25d366 0%, #1da851 100%); border-radius: 14px; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3); border: 2px solid rgba(255,255,255,0.2);"
               onmouseover="this.style.transform='translateX(8px) scale(1.1)'; this.style.boxShadow='0 8px 25px rgba(37, 211, 102, 0.5)'; this.style.borderColor='rgba(255,255,255,0.4)';"
               onmouseout="this.style.transform='translateX(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(37, 211, 102, 0.3)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                <i class="fab fa-whatsapp" style="color: white; font-size: 1.6rem;"></i>
                <span class="social-tooltip" style="position: absolute; left: 70px; background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 100%); color: white; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">WhatsApp</span>
            </a>
            @endif

            @if(!empty($settings['contact_linkedin']))
            <a href="{{ $settings['contact_linkedin'] }}" target="_blank" rel="noopener"
               class="social-btn" data-social="LinkedIn"
               style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0077b5 0%, #005582 100%); border-radius: 14px; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; box-shadow: 0 4px 15px rgba(0, 119, 181, 0.3); border: 2px solid rgba(255,255,255,0.2);"
               onmouseover="this.style.transform='translateX(8px) scale(1.1)'; this.style.boxShadow='0 8px 25px rgba(0, 119, 181, 0.5)'; this.style.borderColor='rgba(255,255,255,0.4)';"
               onmouseout="this.style.transform='translateX(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(0, 119, 181, 0.3)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                <i class="fab fa-linkedin-in" style="color: white; font-size: 1.4rem;"></i>
                <span class="social-tooltip" style="position: absolute; left: 70px; background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 100%); color: white; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">LinkedIn</span>
            </a>
            @endif

            @if(!empty($settings['contact_youtube']))
            <a href="{{ $settings['contact_youtube'] }}" target="_blank" rel="noopener"
               class="social-btn" data-social="YouTube"
               style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #ff0000 0%, #cc0000 100%); border-radius: 14px; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; box-shadow: 0 4px 15px rgba(255, 0, 0, 0.3); border: 2px solid rgba(255,255,255,0.2);"
               onmouseover="this.style.transform='translateX(8px) scale(1.1)'; this.style.boxShadow='0 8px 25px rgba(255, 0, 0, 0.5)'; this.style.borderColor='rgba(255,255,255,0.4)';"
               onmouseout="this.style.transform='translateX(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(255, 0, 0, 0.3)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                <i class="fab fa-youtube" style="color: white; font-size: 1.5rem;"></i>
                <span class="social-tooltip" style="position: absolute; left: 70px; background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 100%); color: white; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">YouTube</span>
            </a>
            @endif

            @if(!empty($settings['contact_tiktok']))
            <a href="{{ $settings['contact_tiktok'] }}" target="_blank" rel="noopener"
               class="social-btn" data-social="TikTok"
               style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #000000 0%, #333333 100%); border-radius: 14px; text-decoration: none; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); position: relative; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4); border: 2px solid rgba(255,255,255,0.2);"
               onmouseover="this.style.transform='translateX(8px) scale(1.1)'; this.style.boxShadow='0 8px 25px rgba(0, 0, 0, 0.6)'; this.style.borderColor='rgba(255,255,255,0.4)';"
               onmouseout="this.style.transform='translateX(0) scale(1)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.4)'; this.style.borderColor='rgba(255,255,255,0.2)';">
                <i class="fab fa-tiktok" style="color: white; font-size: 1.4rem;"></i>
                <span class="social-tooltip" style="position: absolute; left: 70px; background: linear-gradient(135deg, #1e3a5f 0%, #2c5f8d 100%); color: white; padding: 8px 16px; border-radius: 10px; font-size: 0.85rem; font-weight: 600; white-space: nowrap; opacity: 0; pointer-events: none; transition: all 0.3s; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">TikTok</span>
            </a>
            @endif

            <!-- Social Media Label -->
            <div style="margin-top: 8px; padding-top: 12px; border-top: 1px solid rgba(255,255,255,0.2);">
                <div style="writing-mode: vertical-rl; text-orientation: mixed; color: white; font-size: 0.75rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; opacity: 0.9; text-align: center; background: linear-gradient(180deg, #FFE4B5 0%, #f4d9a6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    Connect
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Tooltip hover effect */
        .social-btn:hover .social-tooltip {
            opacity: 1 !important;
            left: 75px !important;
        }

        /* Pulse animation for WhatsApp */
        @keyframes pulse-whatsapp {
            0%, 100% {
                box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
            }
            50% {
                box-shadow: 0 4px 25px rgba(37, 211, 102, 0.6);
            }
        }

        .social-btn[data-social="WhatsApp"] {
            animation: pulse-whatsapp 2s infinite;
        }

        /* =================== IMPROVED MOBILE RESPONSIVENESS =================== */

        /* Tablet Responsiveness */
        @media (max-width: 991.98px) {
            .modern-floating-social {
                left: auto !important;
                right: 0 !important;
                top: auto !important;
                bottom: 20px !important;
                transform: none !important;
            }

            .modern-floating-social > div {
                flex-direction: row !important;
                border-radius: 20px 0 0 20px !important;
                padding: 10px 14px !important;
                border-right: none !important;
                border-left: 1px solid rgba(255,255,255,0.15) !important;
                gap: 10px !important;
            }

            .social-btn {
                width: 44px !important;
                height: 44px !important;
            }

            .social-btn i {
                font-size: 1.2rem !important;
            }

            .social-tooltip {
                display: none !important;
            }

            .modern-floating-social > div > div:last-child {
                display: none !important;
            }

            /* Disable hover effects on tablet/mobile */
            .social-btn:hover {
                transform: none !important;
            }
        }

        /* Mobile Phone Responsiveness */
        @media (max-width: 767.98px) {
            .modern-floating-social {
                bottom: 16px !important;
                /* Safe area for iOS notch/home indicator */
                padding-bottom: env(safe-area-inset-bottom, 0px);
            }

            .modern-floating-social > div {
                flex-direction: row !important;
                border-radius: 16px 0 0 16px !important;
                padding: 8px 10px !important;
                gap: 8px !important;
                max-width: 90vw;
                overflow-x: auto;
                /* Hide scrollbar */
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .modern-floating-social > div::-webkit-scrollbar {
                display: none;
            }

            .social-btn {
                width: 40px !important;
                height: 40px !important;
                flex-shrink: 0;
            }

            .social-btn i {
                font-size: 1.1rem !important;
            }

            /* Make navbar items more touch-friendly */
            .navbar-nav .nav-link {
                padding: 12px 16px !important;
                font-size: 1rem !important;
            }

            .navbar-toggler {
                padding: 8px 12px;
                border-radius: 8px;
            }

            /* Running text responsive */
            .running-text-container {
                font-size: 0.85rem !important;
                padding: 8px 0 !important;
            }
        }

        /* Extra Small Mobile (< 375px) */
        @media (max-width: 374.98px) {
            .modern-floating-social > div {
                padding: 6px 8px !important;
                gap: 6px !important;
            }

            .social-btn {
                width: 36px !important;
                height: 36px !important;
            }

            .social-btn i {
                font-size: 1rem !important;
            }
        }

        /* Landscape orientation on mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .modern-floating-social {
                bottom: 10px !important;
            }

            .modern-floating-social > div {
                padding: 6px 8px !important;
            }

            .social-btn {
                width: 36px !important;
                height: 36px !important;
            }
        }

        /* Footer responsive improvements */
        @media (max-width: 767.98px) {
            footer .container {
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

            footer .row.g-4 {
                gap: 2rem !important;
            }

            footer h5 {
                font-size: 1.1rem !important;
            }

            footer .social-links a {
                width: 40px !important;
                height: 40px !important;
            }

            /* Back to top button mobile */
            .back-to-top {
                width: 45px !important;
                height: 45px !important;
                bottom: 80px !important;
                right: 20px !important;
            }
        }

        /* Ensure content doesn't hide behind floating social */
        @media (max-width: 991.98px) {
            main {
                padding-bottom: 80px !important;
            }
        }

        /* Navbar improvements for mobile */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background: rgba(30, 58, 95, 0.98);
                backdrop-filter: blur(10px);
                margin-top: 16px;
                padding: 16px;
                border-radius: 12px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            }

            .navbar-nav .nav-item {
                margin: 4px 0;
            }

            .navbar-nav .nav-link {
                border-radius: 8px;
                transition: all 0.3s ease;
            }

            .navbar-nav .nav-link:hover,
            .navbar-nav .nav-link.active {
                background: rgba(135, 206, 235, 0.2);
                padding-left: 20px !important;
            }

            .dropdown-menu {
                background: rgba(44, 95, 141, 0.95);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 8px;
                margin-top: 8px !important;
            }

            .dropdown-item {
                color: rgba(255, 255, 255, 0.9);
                padding: 10px 16px;
                border-radius: 6px;
            }

            .dropdown-item:hover {
                background: rgba(135, 206, 235, 0.2);
                color: #ffffff;
            }
        }

        /* Touch-friendly tap targets (minimum 44x44px for accessibility) */
        @media (max-width: 991.98px) {
            .social-btn,
            .navbar-toggler,
            .btn,
            a.nav-link,
            button {
                min-width: 44px;
                min-height: 44px;
            }
        }
    </style>

    <script>
        // Enhanced tooltip functionality
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                const tooltip = this.querySelector('.social-tooltip');
                if (tooltip) {
                    tooltip.style.opacity = '1';
                    tooltip.style.left = '75px';
                }
            });

            btn.addEventListener('mouseleave', function() {
                const tooltip = this.querySelector('.social-tooltip');
                if (tooltip) {
                    tooltip.style.opacity = '0';
                    tooltip.style.left = '70px';
                }
            });
        });
    </script>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    {{-- @stack('scripts') sekarang berada di posisi yang benar --}}
    @stack('scripts')

    {{-- Skrip Global untuk Flatpickr --}}
    {{-- Skrip Global untuk Flatpickr dipindahkan ke resources/js/frontend-calendar.js --}}
    @vite(['resources/js/app.js'])
    </body>
</html>