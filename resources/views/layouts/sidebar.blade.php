{{-- Modern Ocean Resort Admin Sidebar --}}
<div class="flex h-full flex-col bg-gradient-to-b from-admin-darker via-admin-dark to-admin-darker text-gray-100 shadow-2xl">
    {{-- Logo Header with Sky Blue Accent --}}
    <div class="h-20 flex-shrink-0 flex items-center justify-center border-b border-admin-primary/20 bg-admin-darker/50 backdrop-blur-sm">
        <a href="{{ route('admin.dashboard') }}" class="flex flex-col items-center space-y-1 group transition-all duration-300">
            <span class="text-admin-primary font-bold text-2xl tracking-wide group-hover:scale-105 transition-transform duration-300" style="text-shadow: 0 0 20px rgba(135, 206, 235, 0.5);">
                Sora Hotel
            </span>
            <span class="text-admin-accent text-xs font-medium tracking-widest uppercase">
                Admin Panel
            </span>
        </a>
    </div>

    {{-- Wrapper untuk Navigasi dengan Scroll Internal --}}
    <div class="flex-1 overflow-y-auto">
        <nav class="flex-1 space-y-1 py-4 px-2">
        
            @if(Auth::user()->role == 'admin')
                <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-admin-primary tracking-wider">General</h6>
                <a href="{{ route('home') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1 border-l-2 border-transparent hover:border-admin-primary" target="_blank">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat Website
                </a>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.dashboard') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.maintenance.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.maintenance.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.maintenance.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Maintenance Mode
                </a>
                <a href="{{ route('admin.affiliate_page.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.affiliate_page.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.affiliate_page.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Halaman Affiliate
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.bookings.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.bookings.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Bookings
                </a>
                <a href="{{ route('admin.mice-inquiries.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.mice-inquiries.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.mice-inquiries.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    MICE Inquiries
                </a>

                <hr class="border-admin-primary/20 my-3 mx-4">
                <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-admin-primary tracking-wider">Affiliate Program</h6>
                <a href="{{ route('admin.affiliates.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.affiliates.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.affiliates.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Affiliates
                </a>
                <a href="{{ route('admin.commissions.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.commissions.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.commissions.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Commissions
                </a>

                <hr class="border-admin-primary/20 my-3 mx-4">
                <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-admin-primary tracking-wider">Content Management</h6>

                <a href="{{ route('admin.hero-sliders.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.hero-sliders.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.hero-sliders.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Hero Sliders
                </a>

                <a href="{{ route('admin.banners.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.banners.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.banners.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    Banners
                </a>
                <a href="{{ route('admin.price-overrides.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.price-overrides.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.price-overrides.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Custom Prices
                </a>
                <a href="{{ route('admin.mice-kits.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.mice-kits.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.mice-kits.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Digital MICE Kit
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.rooms.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.rooms.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Rooms
                </a>
                <a href="{{ route('admin.mice.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.mice.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.mice.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    MICE
                </a>
                <a href="{{ route('admin.restaurants.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.restaurants.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.restaurants.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Restaurants
                </a>
                <a href="{{ route('admin.recreation-areas.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.recreation-areas.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Recreation Areas</a>
                <hr class="border-admin-primary/20 my-3 mx-4">
                <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-admin-primary tracking-wider">Settings</h6>
                <a href="{{ route('admin.settings.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.settings.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Website Settings
                </a>

                <hr class="border-admin-primary/20 my-3 mx-4">
                <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-admin-primary tracking-wider">User Management</h6>
                <a href="{{ route('admin.users.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.users.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Users
                </a>

            @elseif(Auth::user()->role == 'accounting')
                <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-admin-primary tracking-wider">Affiliate Program</h6>
                <a href="{{ route('admin.commissions.index') }}" class="flex items-center rounded-lg mx-2 px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.commissions.*') ? 'bg-gradient-to-r from-admin-primary to-admin-secondary text-white shadow-lg shadow-admin-primary/50' : 'hover:bg-admin-primary/10 hover:text-admin-primary hover:translate-x-1' }} border-l-2 {{ request()->routeIs('admin.commissions.*') ? 'border-admin-accent' : 'border-transparent hover:border-admin-primary' }}">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Commissions
                </a>
            @endif
        </nav>
    </div>
    
    {{-- User Info Section with Modern Design --}}
    <div class="border-t border-admin-primary/20 p-4 flex-shrink-0 bg-admin-darker/50">
        <div class="flex items-center space-x-3 mb-4">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-admin-primary to-admin-secondary flex items-center justify-center text-white font-bold shadow-lg shadow-admin-primary/30">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-semibold text-white truncate">{{ Auth::user()->name }}</div>
                <div class="text-xs text-admin-accent truncate">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="w-full text-left flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 hover:bg-admin-primary/10 hover:text-admin-primary border-l-2 border-transparent hover:border-admin-primary mb-2">
            <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            Edit Profile
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left flex items-center rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-200 hover:bg-red-500/20 hover:text-red-400 border-l-2 border-transparent hover:border-red-400">
                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                Log Out
            </button>
        </form>
    </div>
</div>