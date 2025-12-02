<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Favicon --}}
        @if(isset($settings['favicon_path']))
            <link rel="icon" href="{{ asset('storage/' . $settings['favicon_path']) }}" type="image/x-icon">
        @endif

        {{-- Website Title --}}
        <title>{{ $settings['website_title'] ?? config('app.name', 'Laravel') }} - Admin Panel</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
            .custom-scrollbar::-webkit-scrollbar { width: 5px; }
            .custom-scrollbar::-webkit-scrollbar-track { background: rgba(255,255,255,0.05); }
            .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255,255,255,0.2); }
        </style>
    </head>
    <body class="font-sans antialiased bg-brand-light text-gray-600">
        <div x-data="{ sidebarOpen: false }" class="relative min-h-screen md:flex">
            
            {{-- Mobile Overlay --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-20 bg-brand-dark/80 backdrop-blur-sm md:hidden"></div>

            {{-- Sidebar --}}
            <aside
                :class="{ '-translate-x-full': !sidebarOpen }"
                class="fixed inset-y-0 left-0 z-30 w-72 transform transition-transform duration-300 md:relative md:translate-x-0 shadow-2xl">
                @include('layouts.sidebar')
            </aside>

            {{-- Main Content --}}
            <div class="flex-1 flex flex-col min-h-screen overflow-hidden">
                
                {{-- Mobile Header --}}
                <header class="flex items-center justify-between bg-white border-b border-gray-100 p-4 md:hidden shadow-sm z-10">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-brand-primary flex items-center justify-center text-white font-bold">S</div>
                        <span class="text-brand-dark font-bold text-lg">Sora Admin</span>
                    </a>
                    <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-gray-500 hover:bg-gray-50 hover:text-brand-primary transition-colors">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </header>

                @if (isset($header))
                    <div class="hidden md:block bg-white border-b border-gray-100 px-8 py-6 shadow-sm">
                       {{ $header }}
                    </div>
                @endif

                <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-brand-light">
                    {{ $slot }}
                </main>
            </div>
        </div>
        
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
        @stack('scripts')
    </body>
</html>