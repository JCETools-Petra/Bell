<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <div class="text-sm text-gray-500">
                {{ now()->format('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- WELCOME SECTION --}}
        <div class="bg-gradient-to-r from-brand-primary to-brand-dark rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-brand-secondary rounded-full opacity-20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 bg-brand-accent rounded-full opacity-10 blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-3xl font-heading font-bold mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-blue-100 text-lg max-w-2xl font-light">
                        Kelola konten website Sora Hotel Merauke, pantau performa bisnis, dan atur reservasi dengan mudah dari sini.
                    </p>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 rounded-xl text-white font-bold transition-all duration-300 group">
                        <span>Lihat Website</span>
                        <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- STATS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Total Visits --}}
            <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-brand-secondary/30 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-brand-primary flex items-center justify-center text-xl group-hover:bg-brand-primary group-hover:text-white transition-colors">
                        <i class="fas fa-globe"></i>
                    </div>
                    <span class="text-xs font-bold px-2 py-1 rounded-lg bg-green-100 text-green-700 flex items-center gap-1">
                        <i class="fas fa-arrow-up text-[0.6rem]"></i> Live
                    </span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Kunjungan</h3>
                <p class="text-3xl font-heading font-bold text-brand-dark mt-1">{{ number_format($totalWebsiteVisits) }}</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between text-xs text-gray-500">
                    <span>Hari ini: <strong class="text-brand-dark">{{ number_format($websiteVisitsToday) }}</strong></span>
                    <span>Bulan ini: <strong class="text-brand-dark">{{ number_format($websiteVisitsThisMonth) }}</strong></span>
                </div>
            </div>

            {{-- Total Bookings --}}
            <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-brand-secondary/30 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl group-hover:bg-teal-600 group-hover:text-white transition-colors">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Booking</h3>
                <p class="text-3xl font-heading font-bold text-brand-dark mt-1">{{ number_format($totalBookings) }}</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between text-xs text-gray-500">
                    <span>Hari ini: <strong class="text-brand-dark">{{ number_format($bookingsToday) }}</strong></span>
                    <span>Bulan ini: <strong class="text-brand-dark">{{ number_format($bookingsThisMonth) }}</strong></span>
                </div>
            </div>

            {{-- Affiliate Clicks --}}
            <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-brand-secondary/30 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <i class="fas fa-mouse-pointer"></i>
                    </div>
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Affiliate Klik</h3>
                <p class="text-3xl font-heading font-bold text-brand-dark mt-1">{{ number_format($totalAffiliateClicks) }}</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between text-xs text-gray-500">
                    <span>Hari ini: <strong class="text-brand-dark">{{ number_format($affiliateClicksToday) }}</strong></span>
                    <span>Bulan ini: <strong class="text-brand-dark">{{ number_format($affiliateClicksThisMonth) }}</strong></span>
                </div>
            </div>

            {{-- Active Affiliates --}}
            <div class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 hover:border-brand-secondary/30 transition-all duration-300 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <i class="fas fa-users"></i>
                    </div>
                    @if($pendingAffiliates > 0)
                    <span class="text-xs font-bold px-2 py-1 rounded-lg bg-yellow-100 text-yellow-700 flex items-center gap-1">
                        {{ $pendingAffiliates }} Pending
                    </span>
                    @endif
                </div>
                <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Affiliate Aktif</h3>
                <p class="text-3xl font-heading font-bold text-brand-dark mt-1">{{ number_format($activeAffiliates) }}</p>
                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between text-xs text-gray-500">
                    <span>Total User: <strong class="text-brand-dark">{{ \App\Models\User::count() }}</strong></span>
                </div>
            </div>
        </div>

        {{-- CHARTS & TABLES --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            {{-- Main Chart / Table --}}
            <div class="xl:col-span-2 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h4 class="font-heading font-bold text-lg text-brand-dark">Tren 7 Hari Terakhir</h4>
                    <button class="text-sm text-brand-secondary font-medium hover:text-brand-primary transition-colors">Lihat Detail</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-bold">
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Kunjungan</th>
                                <th class="px-6 py-4">Klik Affiliate</th>
                                <th class="px-6 py-4">Booking</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($last7Days as $day)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $day['date'] }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full max-w-[100px] h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500 rounded-full" style="width: {{ min(($day['website_visits'] / max(1, collect($last7Days)->max('website_visits'))) * 100, 100) }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-600">{{ number_format($day['website_visits']) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-full max-w-[100px] h-2 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-orange-500 rounded-full" style="width: {{ min(($day['affiliate_clicks'] / max(1, collect($last7Days)->max('affiliate_clicks'))) * 100, 100) }}%"></div>
                                        </div>
                                        <span class="text-xs font-bold text-gray-600">{{ number_format($day['affiliate_clicks']) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-block px-2 py-1 rounded text-xs font-bold bg-teal-50 text-teal-700">
                                        - {{-- Placeholder for daily bookings if not available in $day --}}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Top Affiliates --}}
            <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <h4 class="font-heading font-bold text-lg text-brand-dark">Top Affiliate (Klik)</h4>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-4 custom-scrollbar max-h-[400px]">
                    @forelse($topAffiliatesByClicks as $index => $affiliate)
                    <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-gradient-to-br from-orange-100 to-orange-50 text-orange-600 flex items-center justify-center font-bold text-sm shadow-sm">
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">{{ $affiliate->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $affiliate->user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="block text-lg font-bold text-brand-dark">{{ number_format($affiliate->total_clicks) }}</span>
                            <span class="text-[0.65rem] uppercase tracking-wider text-gray-400 font-bold">Klik</span>
                        </div>
                    </div>
                    @empty
                    <div class="flex flex-col items-center justify-center h-40 text-gray-400">
                        <i class="fas fa-inbox text-3xl mb-2"></i>
                        <p class="text-sm">Belum ada data.</p>
                    </div>
                    @endforelse
                </div>
                <div class="p-4 bg-gray-50 border-t border-gray-100 text-center">
                    <a href="{{ route('admin.affiliates.index') }}" class="text-sm font-bold text-brand-secondary hover:text-brand-primary transition-colors">Lihat Semua Affiliate</a>
                </div>
            </div>
        </div>

        {{-- SYSTEM SUMMARY --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fas fa-door-open"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Kamar</h4>
                    <p class="text-2xl font-bold text-brand-dark">{{ $roomCount }} <span class="text-sm font-normal text-gray-400">Unit</span></p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center text-xl">
                    <i class="fas fa-building"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Ruang MICE</h4>
                    <p class="text-2xl font-bold text-brand-dark">{{ $miceCount }} <span class="text-sm font-normal text-gray-400">Unit</span></p>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.02)] border border-gray-100 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl">
                    <i class="fas fa-utensils"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider">Restoran</h4>
                    <p class="text-2xl font-bold text-brand-dark">2 <span class="text-sm font-normal text-gray-400">Outlet</span></p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

