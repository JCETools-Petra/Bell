<x-guest-layout>
    @push('styles')
    <style>
        /* =================== MODERN LOGIN FORM STYLES =================== */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--resort-dark);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid rgba(135, 206, 235, 0.3);
            border-radius: 12px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: #ffffff;
            color: #333;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--resort-primary);
            box-shadow: 0 0 0 4px rgba(135, 206, 235, 0.1);
        }

        .form-input::placeholder {
            color: #999;
        }

        /* Password Input Container */
        .password-input-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: var(--resort-secondary);
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Remember Me Checkbox */
        .remember-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 24px;
        }

        .custom-checkbox {
            position: relative;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .custom-checkbox input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }

        .checkbox-box {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(135, 206, 235, 0.5);
            border-radius: 6px;
            margin-right: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .custom-checkbox input[type="checkbox"]:checked ~ .checkbox-box {
            background: linear-gradient(135deg, var(--resort-primary), var(--resort-secondary));
            border-color: var(--resort-primary);
        }

        .checkbox-box svg {
            width: 14px;
            height: 14px;
            stroke: #ffffff;
            stroke-width: 3;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .custom-checkbox input[type="checkbox"]:checked ~ .checkbox-box svg {
            opacity: 1;
        }

        .checkbox-label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        /* Gold Gradient Login Button */
        .btn-login {
            width: 100%;
            padding: 16px 24px;
            background: linear-gradient(135deg, var(--resort-gold) 0%, #B8860B 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 24px rgba(212, 175, 55, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(212, 175, 55, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Forgot Password Link */
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: var(--resort-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--resort-primary);
        }

        /* Error Messages */
        .error-message {
            color: #dc2626;
            font-size: 0.85rem;
            margin-top: 6px;
            font-weight: 500;
        }

        /* Status Messages */
        .status-message {
            padding: 14px 18px;
            background: linear-gradient(135deg, rgba(135, 206, 235, 0.1), rgba(70, 130, 180, 0.1));
            border-left: 4px solid var(--resort-primary);
            border-radius: 8px;
            color: var(--resort-dark);
            font-size: 0.9rem;
            margin-bottom: 24px;
            font-weight: 500;
        }

        /* Footer Options */
        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
        }

        /* Back to Home Link */
        .back-home {
            text-align: center;
            margin-top: 32px;
            padding-top: 32px;
            border-top: 1px solid rgba(135, 206, 235, 0.2);
        }

        .back-home a {
            color: #666;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .back-home a:hover {
            color: var(--resort-primary);
        }

        .back-home svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>
    @endpush

    {{-- Logo --}}
    <div class="login-logo">
        <a href="/">
            @if(isset($settings['logo_path']) && $settings['logo_path'])
                <img src="{{ asset('storage/' . $settings['logo_path']) }}" alt="{{ $settings['website_title'] ?? 'Logo' }}">
            @else
                <h1>{{ $settings['website_title'] ?? config('app.name') }}</h1>
            @endif
        </a>
    </div>

    {{-- Form Header --}}
    <div class="form-header">
        <h2 class="form-title">Sign In</h2>
        <p class="form-subtitle">Enter your credentials to access your account</p>
    </div>

    {{-- Status Message --}}
    @if (session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    {{-- Login Form --}}
    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email Field --}}
        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email"
                   type="email"
                   name="email"
                   class="form-input"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   autocomplete="username"
                   placeholder="your@email.com">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Password Field --}}
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="password-input-wrapper">
                <input id="password"
                       type="password"
                       name="password"
                       class="form-input"
                       required
                       autocomplete="current-password"
                       placeholder="Enter your password">
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <svg id="eye-icon" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                    <svg id="eye-off-icon" viewBox="0 0 24 24" style="display: none;">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                        <line x1="1" y1="1" x2="23" y2="23"></line>
                    </svg>
                </button>
            </div>
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- Remember Me & Forgot Password --}}
        <div class="form-footer">
            <label class="custom-checkbox">
                <input type="checkbox" name="remember" id="remember_me">
                <div class="checkbox-box">
                    <svg viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                </div>
                <span class="checkbox-label">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color: var(--resort-secondary); text-decoration: none; font-size: 0.9rem; font-weight: 500;">
                    Forgot password?
                </a>
            @endif
        </div>

        {{-- Login Button --}}
        <div style="margin-top: 32px;">
            <button type="submit" class="btn-login">
                Sign In
            </button>
        </div>
    </form>

    {{-- Back to Home --}}
    <div class="back-home">
        <a href="/">
            <svg viewBox="0 0 24 24">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Back to Home
        </a>
    </div>

    @push('scripts')
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }
    </script>
    @endpush
</x-guest-layout>
