<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    @if(isset($settings['favicon_path']))
        <link rel="icon" href="{{ asset('storage/' . $settings['favicon_path']) }}" type="image/x-icon">
    @endif
    
    <title>@yield('seo_title', $settings['website_title'] ?? 'Bell Hotel Merauke')</title>
    <meta name="description" content="@yield('meta_description', 'Bell Hotel Merauke adalah hotel modern yang berlokasi strategis di pusat Kota Merauke.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Montserrat:wght@400;500;700&family=Playfair+Display:wght@700;800&family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}?v={{ @filemtime(public_path('css/custom-style.css')) }}">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
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
    <footer class="footer mt-auto py-4 bg-dark text-white-50">
        <div class="container text-center">
            <div class="mb-3">
                <a href="{{ route('home') }}" class="text-white-50 mx-2 text-decoration-none">Home</a>
                <a href="{{ route('rooms.index') }}" class="text-white-50 mx-2 text-decoration-none">Rooms</a>
                <a href="{{ route('contact.index') }}" class="text-white-50 mx-2 text-decoration-none">Contact Us</a>
                <a href="{{ route('pages.terms') }}" class="text-white-50 mx-2 text-decoration-none">Terms & Conditions</a>
            </div>
            <p class="mb-0 text-white">&copy; {{ date('Y') }} {{ $settings['website_title'] ?? 'Bell Hotel Merauke' }}. All Rights Reserved.</p>
        </div>
    </footer>
    <div class="floating-social-bar" aria-label="Social Media Links">
        <div class="social-tab" aria-hidden="true">Social&nbsp;Media</div>
        <ul>
            @if(!empty($settings['contact_facebook']))
                <li class="facebook">
                    <a href="{{ $settings['contact_facebook'] }}" target="_blank" rel="noopener" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
            @endif
            @if(!empty($settings['contact_instagram']))
                <li class="instagram">
                    <a href="{{ $settings['contact_instagram'] }}" target="_blank" rel="noopener" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                </li>
            @endif
            @if(!empty($settings['contact_phone']))
                @php
                    $phone = $settings['contact_phone'];
                    $cleanedPhone = preg_replace('/[^0-9]/', '', $phone);
                    $waPhone = substr($cleanedPhone, 0, 1) === '0'
                        ? '62' . substr($cleanedPhone, 1)
                        : $cleanedPhone;
                @endphp
                <li class="whatsapp">
                    <a href="https://wa.me/{{ $waPhone }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </li>
            @endif
            @if(!empty($settings['contact_linkedin']))
                <li class="linkedin">
                    <a href="{{ $settings['contact_linkedin'] }}" target="_blank" rel="noopener" aria-label="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </li>
            @endif
            @if(!empty($settings['contact_youtube']))
                <li class="youtube">
                    <a href="{{ $settings['contact_youtube'] }}" target="_blank" rel="noopener" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </li>
            @endif
            @if(!empty($settings['contact_tiktok']))
                <li class="tiktok">
                    <a href="{{ $settings['contact_tiktok'] }}" target="_blank" rel="noopener" aria-label="TikTok">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        async function getPricesForMonth(year, month) {
            try {
                const response = await fetch(`/api/monthly-room-prices?year=${year}&month=${month + 1}`);
                if (!response.ok) return {};
                return await response.json();
            } catch (error) {
                console.error('Error fetching monthly prices:', error);
                return {};
            }
        }

        // ==========================================================
        // LOGIKA BARU YANG LEBIH ANDAL: Cek URL Halaman
        // ==========================================================
        const isOnPaymentPage = window.location.pathname.includes('/booking/payment');

        let config = {
            dateFormat: "d-m-Y",
            minDate: "today"
        };

        // Hanya tambahkan fungsi harga jika BUKAN di halaman pembayaran
        if (!isOnPaymentPage) {
            config.onReady = async function(selectedDates, dateStr, instance) {
                const year = instance.currentYear;
                const month = instance.currentMonth;
                const prices = await getPricesForMonth(year, month);
                instance.prices = prices; 
                instance.redraw();
            };
            config.onMonthChange = async function(selectedDates, dateStr, instance) {
                const year = instance.currentYear;
                const month = instance.currentMonth;
                const prices = await getPricesForMonth(year, month);
                instance.prices = prices;
                instance.redraw();
            };
            config.onDayCreate = function(dObj, dStr, fp, dayElem) {
                const date = dayElem.dateObj;
                const dateString = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                
                if (fp.prices && fp.prices[dateString]) {
                    const priceInfo = fp.prices[dateString];
                    const priceElement = document.createElement('div');
                    priceElement.className = 'flatpickr-price-info';
                    priceElement.textContent = `${parseInt(priceInfo.price / 1000)}k`;

                    if (priceInfo.is_special) {
                        priceElement.classList.add('special-price');
                    }
                    dayElem.appendChild(priceElement);
                }
            };
        }
        
        // Terapkan konfigurasi ke semua datepicker
        flatpickr(".datepicker", config);
    });
    </script>
    
    <style>
        /* CSS untuk kalender tetap sama */
        .flatpickr-calendar { font-family: var(--primary-font) !important; width: auto !important; box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important; border-radius: 8px !important; }
        .flatpickr-day { position: relative; font-family: var(--primary-font); height: 38px; line-height: 24px; }
        .flatpickr-day .flatpickr-price-info { font-size: 0.65rem; color: #28a745; position: absolute; bottom: 2px; left: 0; width: 100%; text-align: center; font-weight: bold; line-height: 1; }
        .flatpickr-day .flatpickr-price-info.special-price { color: #dc3545; }
        .flatpickr-weekday { font-family: var(--primary-font) !important; font-weight: 500 !important; color: #6c757d !important; }
        .flatpickr-months .flatpickr-month { height: 40px; }
        .flatpickr-current-month { font-size: 1.2rem !important; padding-top: 5px; }
        span.flatpickr-weekday, .numInputWrapper, .flatpickr-current-month .numInput { font-family: var(--primary-font) !important; }
    </style>
</body>
</html>
