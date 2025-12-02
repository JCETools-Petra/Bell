<div class="flex h-full flex-col bg-brand-dark text-white shadow-2xl border-r border-white/5">
    {{-- LOGO SECTION --}}
    <div class="h-20 flex-shrink-0 flex items-center justify-center border-b border-white/10 bg-brand-dark relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-brand-secondary/10 to-transparent"></div>
        <a href="{{ route('admin.dashboard') }}" class="relative z-10 flex items-center gap-3 group">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-secondary to-brand-primary flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                <span class="text-white font-heading font-bold text-xl">S</span>
            </div>
            <div class="flex flex-col">
                <span class="text-white font-heading font-bold text-lg tracking-wide leading-none">SORA</span>
                <span class="text-brand-secondary text-[0.6rem] uppercase tracking-[0.2em] font-medium">Hotel Admin</span>
            </div>
        </a>
    </div>

    {{-- NAVIGATION --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-8">
        
        {{-- MENU: ADMIN & FRONT OFFICE --}}
        @if(in_array(Auth::user()->role, ['admin', 'frontoffice']))
            <div>
                <h6 class="px-2 mb-3 text-xs font-bold uppercase tracking-widest text-gray-500/80">General</h6>
                <div class="space-y-1">
                    <a href="{{ route('home') }}" target="_blank" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium text-gray-400 hover:bg-white/5 hover:text-white transition-all duration-200">
                        <i class="fas fa-external-link-alt w-5 text-center mr-3 group-hover:text-brand-secondary transition-colors"></i>
                        Visit Website
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-th-large w-5 text-center mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Dashboard
                    </a>
                </div>
            </div>

            <div>
                <h6 class="px-2 mb-3 text-xs font-bold uppercase tracking-widest text-gray-500/80">Booking & Ops</h6>
                <div class="space-y-1">
                    <a href="{{ route('admin.bookings.index', ['type' => 'room']) }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->input('type') == 'room' || (request()->routeIs('admin.bookings.*') && !request()->input('type')) ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-bed w-5 text-center mr-3 {{ request()->input('type') == 'room' || (request()->routeIs('admin.bookings.*') && !request()->input('type')) ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Room Bookings
                    </a>

                    <a href="{{ route('admin.bookings.index', ['type' => 'mice']) }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->input('type') == 'mice' ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-handshake w-5 text-center mr-3 {{ request()->input('type') == 'mice' ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        MICE Bookings
                    </a>

                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.maintenance.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.maintenance.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-tools w-5 text-center mr-3 {{ request()->routeIs('admin.maintenance.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Maintenance Mode
                    </a>
                    @endif
                </div>
            </div>

            <div>
                <h6 class="px-2 mb-3 text-xs font-bold uppercase tracking-widest text-gray-500/80">Affiliate System</h6>
                <div class="space-y-1">
                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.affiliates.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.affiliates.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-users w-5 text-center mr-3 {{ request()->routeIs('admin.affiliates.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Affiliates
                    </a>
                    @endif

                    <a href="{{ route('admin.commissions.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.commissions.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-wallet w-5 text-center mr-3 {{ request()->routeIs('admin.commissions.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Commissions
                    </a>

                    @if(Auth::user()->role == 'admin')
                    <a href="{{ route('admin.affiliate_page.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.affiliate_page.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-file-alt w-5 text-center mr-3 {{ request()->routeIs('admin.affiliate_page.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Affiliate Page
                    </a>
                    @endif
                </div>
            </div>

            @if(Auth::user()->role == 'admin')
            <div>
                <h6 class="px-2 mb-3 text-xs font-bold uppercase tracking-widest text-gray-500/80">Content & Settings</h6>
                <div class="space-y-1">
                    <a href="{{ route('admin.hero-sliders.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.hero-sliders.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-images w-5 text-center mr-3 {{ request()->routeIs('admin.hero-sliders.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Hero Sliders
                    </a>
                    <a href="{{ route('admin.banners.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.banners.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-ad w-5 text-center mr-3 {{ request()->routeIs('admin.banners.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Banners
                    </a>
                    <a href="{{ route('admin.price-overrides.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.price-overrides.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-tags w-5 text-center mr-3 {{ request()->routeIs('admin.price-overrides.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Custom Prices
                    </a>
                    <a href="{{ route('admin.mice-kits.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.mice-kits.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-file-pdf w-5 text-center mr-3 {{ request()->routeIs('admin.mice-kits.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Digital MICE Kit
                    </a>
                    <a href="{{ route('admin.rooms.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.rooms.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-door-open w-5 text-center mr-3 {{ request()->routeIs('admin.rooms.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Rooms
                    </a>
                    <a href="{{ route('admin.mice.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.mice.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-building w-5 text-center mr-3 {{ request()->routeIs('admin.mice.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        MICE Rooms
                    </a>
                    <a href="{{ route('admin.restaurants.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.restaurants.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                        <i class="fas fa-utensils w-5 text-center mr-3 {{ request()->routeIs('admin.restaurants.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                        Restaurants
                    </a>
                    
                    <div class="pt-4 mt-4 border-t border-white/10">
                        <a href="{{ route('admin.settings.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.settings.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                            <i class="fas fa-cog w-5 text-center mr-3 {{ request()->routeIs('admin.settings.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                            Website Settings
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                            <i class="fas fa-user-cog w-5 text-center mr-3 {{ request()->routeIs('admin.users.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                            User Management
                        </a>
                    </div>
                </div>
            </div>
            @endif

        @elseif(Auth::user()->role == 'accounting')
            <div>
                <h6 class="px-2 mb-3 text-xs font-bold uppercase tracking-widest text-gray-500/80">Finance</h6>
                <a href="{{ route('admin.commissions.index') }}" class="group flex items-center rounded-xl px-3 py-2.5 text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.commissions.*') ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30' : 'text-gray-400 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-wallet w-5 text-center mr-3 {{ request()->routeIs('admin.commissions.*') ? 'text-brand-secondary' : 'group-hover:text-brand-secondary transition-colors' }}"></i>
                    Commissions
                </a>
            </div>
        @endif
    </div>
    
    {{-- USER PROFILE --}}
    <div class="border-t border-white/10 bg-brand-dark/50 p-4 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-brand-secondary to-brand-primary flex items-center justify-center text-white font-bold text-lg shadow-md border border-white/10">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs font-medium text-gray-400 truncate">{{ Auth::user()->email }}</p>
            </div>
        </div>
        
        <div class="mt-4 grid grid-cols-2 gap-2">
            <a href="{{ route('profile.edit') }}" class="text-center rounded-lg py-2 text-xs font-medium bg-white/5 text-gray-300 hover:bg-brand-primary hover:text-white transition-all duration-200">
                Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-center rounded-lg py-2 text-xs font-medium bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-200">
                    Log Out
                </button>
            </form>
        </div>
    </div>
</div>
