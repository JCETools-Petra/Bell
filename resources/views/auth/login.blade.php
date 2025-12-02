@extends('layouts.frontend')

@section('seo_title', 'Login - Sora Hotel Merauke')
@section('meta_description', 'Masuk ke akun Anda untuk mengelola pemesanan dan akses fitur member Sora Hotel Merauke.')

@section('content')
    <div class="min-h-screen bg-brand-dark flex items-center justify-center py-20 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
        
        {{-- Background Elements --}}
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand-secondary rounded-full opacity-20 blur-3xl animate-pulse"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-brand-primary rounded-full opacity-20 blur-3xl"></div>
            <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=1920&auto=format&fit=crop" 
                 class="absolute inset-0 w-full h-full object-cover opacity-10 mix-blend-overlay" alt="Background">
        </div>

        <div class="relative z-10 w-full max-w-md">
            
            {{-- Logo & Header --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-block mb-4">
                    {{-- Ganti dengan logo Anda jika ada, atau gunakan teks --}}
                    @if(isset($settings['logo_path']) && $settings['logo_path'])
                        <img src="{{ asset('storage/' . $settings['logo_path']) }}" class="h-16 w-auto mx-auto drop-shadow-lg" alt="Sora Hotel">
                    @else
                        <span class="text-3xl font-heading font-bold text-white tracking-wider">Sora Hotel</span>
                    @endif
                </a>
                <h2 class="text-2xl font-bold text-white tracking-tight">
                    Selamat Datang Kembali
                </h2>
                <p class="mt-2 text-sm text-blue-200">
                    Silakan masuk ke akun Anda
                </p>
            </div>

            {{-- Login Card --}}
            <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden border border-white/20 p-8 sm:p-10 relative">
                
                {{-- Session Status --}}
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    {{-- Email Address --}}
                    <div>
                        <label for="email" class="block text-xs font-bold text-gray-500 uppercase mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:ring-brand-primary focus:border-brand-primary transition-colors placeholder-gray-400"
                                   placeholder="nama@email.com">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-bold text-gray-500 uppercase mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-gray-400"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-10 pr-4 py-3 text-sm focus:ring-brand-primary focus:border-brand-primary transition-colors placeholder-gray-400"
                                   placeholder="••••••••">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between text-sm">
                        <label for="remember_me" class="flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" 
                                   class="rounded border-gray-300 text-brand-primary focus:ring-brand-primary cursor-pointer">
                            <span class="ml-2 text-gray-600">Ingat Saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-medium text-brand-primary hover:text-brand-secondary transition-colors">
                                Lupa Password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-brand-primary to-brand-secondary hover:from-brand-secondary hover:to-brand-primary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-primary transition-all transform hover:-translate-y-0.5">
                        Masuk Sekarang
                    </button>

                    {{-- Register Link --}}
                    <div class="text-center mt-6 pt-4 border-t border-gray-100">
                        <p class="text-sm text-gray-500">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-bold text-brand-primary hover:text-brand-secondary transition-colors">
                                Daftar Gratis
                            </a>
                        </p>
                        <p class="text-xs text-gray-400 mt-2">
                            Atau daftar sebagai <a href="{{ route('affiliate.register.create') }}" class="text-brand-secondary hover:underline font-bold">Partner Affiliate</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <div class="text-center mt-8 text-xs text-blue-200/60">
                &copy; {{ date('Y') }} {{ $settings['website_title'] ?? 'Sora Hotel' }}. All rights reserved.
            </div>

        </div>
    </div>
@endsection

