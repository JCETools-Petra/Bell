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
        {{-- KONTEN NAVBAR ANDA DI SINI --}}
    </nav>
    <main>
        @yield('content')
    </main>
    <footer class="footer mt-auto py-4 bg-dark text-white-50">
        {{-- KONTEN FOOTER ANDA DI SINI --}}
    </footer>
    <div class="floating-social-bar" aria-label="Social Media Links">
        {{-- KONTEN SOCIAL MEDIA BAR ANDA DI SINI --}}
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    @stack('scripts')

    {{-- ========================================================== --}}
    {{-- SKRIP UTAMA DENGAN LOGIKA PEMERIKSAAN URL --}}
    {{-- ========================================================== --}}
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

        document.querySelectorAll('.datepicker').forEach(function(element) {
            let config = {
                dateFormat: "d-m-Y",
                minDate: "today"
            };

            // LOGIKA BARU YANG LEBIH ANDAL: Cek URL Halaman
            const isOnPaymentPage = window.location.pathname.includes('/booking/payment');

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
            
            flatpickr(element, config);
        });
    });
    </script>
    
    <style>
        /* CSS untuk kalender tetap sama */
    </style>
</body>
</html>