<div class="flex h-full flex-col bg-brand-black text-gray-300">
    <div class="h-16 flex items-center justify-center border-b border-gray-700">
        <a href="{{ route('admin.dashboard') }}" class="text-brand-gold font-bold text-2xl">
            Bell Hotel
        </a>
    </div>

    <nav class="flex-1 space-y-2 py-4 px-2">
        @php
            $navItems = [
                ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
                ['label' => 'Bookings', 'route' => 'admin.bookings.index', 'active' => 'admin.bookings.*'],
                ['label' => 'Rooms', 'route' => 'admin.rooms.index', 'active' => 'admin.rooms.*'],
                ['label' => 'MICE', 'route' => 'admin.mice.index', 'active' => 'admin.mice.*'],
                ['label' => 'Restaurants', 'route' => 'admin.restaurants.index', 'active' => 'admin.restaurants.*'], // <-- TAMBAHKAN BARIS INI
                ['label' => 'Homepage Settings', 'route' => 'admin.homepage.edit', 'active' => 'admin.homepage.*'],
                ['label' => 'Contact Settings', 'route' => 'admin.contact.edit', 'active' => 'admin.contact.*'],
                ['label' => 'Mice Inquiries', 'route' => 'admin.mice-inquiries.index', 'active' => 'admin.mice-inquiries.*'],
            ];
        @endphp

        @foreach ($navItems as $item)
            <a href="{{ route($item['route']) }}"
               class="flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors
                      {{ request()->routeIs($item['active'])
                         ? 'bg-brand-gold text-brand-black'
                         : 'hover:bg-gray-700 hover:text-white' }}">
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
    
    <div class="border-t border-gray-700 p-4">
        <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
        <div class="text-xs text-gray-400">{{ Auth::user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}" class="mt-3">
            @csrf
            <button type="submit" class="w-full text-left flex items-center rounded-md px-4 py-2.5 text-sm font-medium transition-colors hover:bg-brand-red hover:text-white">
                Log Out
            </button>
        </form>
    </div>
</div>