<div class="flex h-full flex-col bg-brand-black text-gray-300">
    <div class="h-16 flex items-center justify-center border-b border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="text-brand-gold font-bold text-2xl">
            Bell Hotel
        </a>
    </div>

    <nav class="flex-1 space-y-1 py-4 px-2">
        
        {{-- ========================================================== --}}
        {{-- LOGIKA BARU UNTUK MENAMPILKAN MENU BERDASARKAN PERAN --}}
        {{-- ========================================================== --}}

        {{-- Tampilkan semua menu untuk SUPER ADMIN --}}
        @if(Auth::user()->role == 'admin')
            <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-gray-400">General</h6>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Dashboard</a>
            <a href="{{ route('admin.bookings.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Bookings</a>
            <a href="{{ route('admin.mice-inquiries.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.mice-inquiries.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">MICE Inquiries</a>

            <hr class="border-gray-700 my-2">
            <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-gray-400">Affiliate Program</h6>
            <a href="{{ route('admin.affiliates.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.affiliates.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Affiliates</a>
            <a href="{{ route('admin.commissions.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.commissions.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Commissions</a>

            <hr class="border-gray-700 my-2">
            <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-gray-400">Content Management</h6>
            <a href="{{ route('admin.rooms.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.rooms.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Rooms</a>
            <a href="{{ route('admin.mice.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.mice.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">MICE</a>
            <a href="{{ route('admin.restaurants.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.restaurants.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Restaurants</a>

            <hr class="border-gray-700 my-2">
            <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-gray-400">Settings</h6>
            <a href="{{ route('admin.homepage.edit') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.homepage.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Homepage Settings</a>
            <a href="{{ route('admin.contact.edit') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.contact.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Contact Settings</a>
            
            <hr class="border-gray-700 my-2">
            <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-gray-400">User Management</h6>
             <a href="{{ route('admin.users.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">Users</a>

        {{-- Jika bukan admin, cek apakah dia ACCOUNTING --}}
        @elseif(Auth::user()->role == 'accounting')
            <h6 class="px-4 pt-2 pb-1 text-xs font-semibold uppercase text-gray-400">Affiliate Program</h6>
            {{-- Accounting hanya bisa melihat menu Commissions --}}
            <a href="{{ route('admin.commissions.index') }}" class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors {{ request()->routeIs('admin.commissions.*') ? 'bg-brand-gold text-brand-black' : 'hover:bg-gray-700 hover:text-white' }}">
                Commissions
            </a>
        @endif
        {{-- ========================================================== --}}
        {{-- AKHIR DARI PERUBAHAN --}}
        {{-- ========================================================== --}}
    </nav>
    
    <div class="border-t border-gray-700 p-4">
        <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
        <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full text-left flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors hover:bg-red-600 hover:text-white">
                Log Out
            </button>
        </form>
    </div>
</div>