<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Menampilkan judul dinamis dari database --}}
    <title>{{ $settings['website_title'] ?? config('app.name', 'Laravel') }}</title>

    {{-- Menampilkan favicon dinamis dari database --}}
    @if(isset($settings['favicon_path']) && $settings['favicon_path'])
        <link rel="icon" href="{{ asset('storage/' . $settings['favicon_path']) }}" type="image/x-icon">
    @endif

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =================== PROFESSIONAL RESORT LOGIN THEME =================== */
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
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #ffffff;
            overflow-x: hidden;
        }

        /* =================== LOGIN CONTAINER =================== */
        .login-wrapper {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            position: relative;
        }

        /* =================== LEFT SIDE - FORM =================== */
        .login-form-side {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }

        /* Subtle Background Pattern */
        .login-form-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 30%, rgba(135, 206, 235, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(70, 130, 180, 0.03) 0%, transparent 50%);
            pointer-events: none;
        }

        .login-form-container {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }

        /* =================== RIGHT SIDE - IMAGE HERO =================== */
        .login-hero-side {
            position: relative;
            background: linear-gradient(135deg, var(--resort-dark) 0%, var(--resort-secondary) 50%, var(--resort-primary) 100%);
            overflow: hidden;
        }

        .hero-background {
            position: absolute;
            inset: 0;
            background-image: url('data:image/svg+xml,%3Csvg width="100" height="100" xmlns="http://www.w3.org/2000/svg"%3E%3Cpath d="M0 50 Q 25 30, 50 50 T 100 50 V 100 H 0 Z" fill="rgba(255,255,255,0.05)"/%3E%3C/svg%3E');
            background-size: 200px 100px;
            background-repeat: repeat;
            animation: wave 20s linear infinite;
            opacity: 0.3;
        }

        @keyframes wave {
            0% { background-position: 0 0; }
            100% { background-position: 200px 0; }
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(30, 58, 95, 0.9) 0%, rgba(70, 130, 180, 0.85) 100%);
            backdrop-filter: blur(10px);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 80px;
            color: #ffffff;
            text-align: center;
        }

        .hero-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            border-radius: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 40px;
            backdrop-filter: blur(20px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        }

        .hero-icon svg {
            width: 64px;
            height: 64px;
            stroke: #ffffff;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 20px;
            letter-spacing: -1px;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.95;
            font-weight: 400;
            line-height: 1.6;
            max-width: 400px;
        }

        .hero-decorative-dots {
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 12px;
        }

        .hero-dot {
            width: 8px;
            height: 8px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        .hero-dot:nth-child(2) {
            animation-delay: 0.3s;
        }

        .hero-dot:nth-child(3) {
            animation-delay: 0.6s;
        }

        @keyframes pulse-dot {
            0%, 100% { transform: scale(1); opacity: 0.4; }
            50% { transform: scale(1.5); opacity: 1; }
        }

        /* =================== LOGO =================== */
        .login-logo {
            text-align: center;
            margin-bottom: 48px;
        }

        .login-logo img {
            max-height: 80px;
            width: auto;
            margin: 0 auto;
        }

        .login-logo h1 {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--resort-secondary), var(--resort-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* =================== FORM HEADER =================== */
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--resort-dark);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .form-subtitle {
            font-size: 1rem;
            color: #666;
            font-weight: 400;
        }

        /* =================== RESPONSIVE =================== */
        @media (max-width: 991.98px) {
            .login-wrapper {
                grid-template-columns: 1fr;
            }

            .login-hero-side {
                display: none;
            }

            .login-form-side {
                padding: 40px 24px;
            }

            .login-form-container {
                max-width: 100%;
            }

            .hero-content {
                padding: 40px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 767.98px) {
            .login-form-side {
                padding: 30px 20px;
            }

            .form-title {
                font-size: 1.75rem;
            }

            .login-logo img {
                max-height: 60px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="login-wrapper">
        {{-- LEFT SIDE: FORM --}}
        <div class="login-form-side">
            <div class="login-form-container">
                {{ $slot }}
            </div>
        </div>

        {{-- RIGHT SIDE: HERO IMAGE --}}
        <div class="login-hero-side">
            <div class="hero-background"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <div class="hero-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <h1 class="hero-title">Welcome Back</h1>
                <p class="hero-subtitle">Sign in to access your resort management dashboard and continue your journey</p>
                <div class="hero-decorative-dots">
                    <div class="hero-dot"></div>
                    <div class="hero-dot"></div>
                    <div class="hero-dot"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
