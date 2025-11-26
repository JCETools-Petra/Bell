<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">
                    {{ __('Admin Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Selamat datang kembali! Berikut ringkasan performa Sora Hotel</p>
            </div>
            <div class="hidden md:flex items-center space-x-2 bg-gradient-to-r from-admin-primary to-admin-secondary text-white px-4 py-2 rounded-lg shadow-lg shadow-admin-primary/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span class="font-semibold">{{ \Carbon\Carbon::now()->format('d M Y') }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Section with Ocean Theme -->
            <div class="bg-gradient-to-br from-admin-primary via-admin-secondary to-admin-tertiary overflow-hidden shadow-2xl rounded-2xl shadow-admin-primary/30 border border-admin-primary/20">
                <div class="p-8 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
                    <div class="relative z-10">
                        <div class="flex items-center space-x-3 mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <h3 class="text-3xl font-bold">Selamat Datang di Admin Panel!</h3>
                        </div>
                        <p class="text-white/90 text-lg leading-relaxed">
                            Kelola konten website Sora Hotel Merauke dan pantau statistik pengunjung serta performa affiliate secara real-time dari dashboard yang powerful ini.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Website Visit Statistics -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-800">Statistik Kunjungan Website</h4>
                            <p class="text-sm text-gray-500">Pantau traffic website secara real-time</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="group relative p-6 bg-gradient-to-br from-admin-primary/10 to-admin-primary/5 rounded-xl border-2 border-admin-primary/20 hover:border-admin-primary/40 transition-all duration-300 hover:shadow-lg hover:shadow-admin-primary/20">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-admin-primary/20 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-admin-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-admin-secondary mb-1">Total Kunjungan</h3>
                            <p class="text-3xl font-extrabold bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">{{ number_format($totalWebsiteVisits) }}</p>
                        </div>
                        <div class="group relative p-6 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border-2 border-green-200 hover:border-green-400 transition-all duration-300 hover:shadow-lg hover:shadow-green-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-green-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-green-700 mb-1">Kunjungan Hari Ini</h3>
                            <p class="text-3xl font-extrabold text-green-600">{{ number_format($websiteVisitsToday) }}</p>
                        </div>
                        <div class="group relative p-6 bg-gradient-to-br from-purple-50 to-violet-50 rounded-xl border-2 border-purple-200 hover:border-purple-400 transition-all duration-300 hover:shadow-lg hover:shadow-purple-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-purple-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-purple-700 mb-1">Kunjungan Minggu Ini</h3>
                            <p class="text-3xl font-extrabold text-purple-600">{{ number_format($websiteVisitsThisWeek) }}</p>
                        </div>
                        <div class="group relative p-6 bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl border-2 border-indigo-200 hover:border-indigo-400 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-indigo-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-indigo-700 mb-1">Kunjungan Bulan Ini</h3>
                            <p class="text-3xl font-extrabold text-indigo-600">{{ number_format($websiteVisitsThisMonth) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Affiliate Link Click Statistics -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-br from-orange-500 to-red-500 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-800">Statistik Klik Link Affiliate</h4>
                            <p class="text-sm text-gray-500">Monitor performa affiliate link secara detail</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="group relative p-6 bg-gradient-to-br from-orange-50 to-amber-50 rounded-xl border-2 border-orange-200 hover:border-orange-400 transition-all duration-300 hover:shadow-lg hover:shadow-orange-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-orange-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-orange-700 mb-1">Total Klik Affiliate</h3>
                            <p class="text-3xl font-extrabold text-orange-600">{{ number_format($totalAffiliateClicks) }}</p>
                        </div>
                        <div class="group relative p-6 bg-gradient-to-br from-red-50 to-rose-50 rounded-xl border-2 border-red-200 hover:border-red-400 transition-all duration-300 hover:shadow-lg hover:shadow-red-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-red-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-red-700 mb-1">Klik Hari Ini</h3>
                            <p class="text-3xl font-extrabold text-red-600">{{ number_format($affiliateClicksToday) }}</p>
                        </div>
                        <div class="group relative p-6 bg-gradient-to-br from-pink-50 to-fuchsia-50 rounded-xl border-2 border-pink-200 hover:border-pink-400 transition-all duration-300 hover:shadow-lg hover:shadow-pink-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-pink-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-pink-700 mb-1">Klik Minggu Ini</h3>
                            <p class="text-3xl font-extrabold text-pink-600">{{ number_format($affiliateClicksThisWeek) }}</p>
                        </div>
                        <div class="group relative p-6 bg-gradient-to-br from-rose-50 to-red-50 rounded-xl border-2 border-rose-200 hover:border-rose-400 transition-all duration-300 hover:shadow-lg hover:shadow-rose-200">
                            <div class="flex items-start justify-between mb-3">
                                <div class="p-2 bg-rose-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            <h3 class="text-sm font-semibold text-rose-700 mb-1">Klik Bulan Ini</h3>
                            <p class="text-3xl font-extrabold text-rose-600">{{ number_format($affiliateClicksThisMonth) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking & Affiliate Stats -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Booking Statistics -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">Statistik Booking</h4>
                                <p class="text-sm text-gray-500">Data reservasi hotel</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="group p-5 bg-gradient-to-br from-teal-50 to-cyan-50 rounded-xl border-2 border-teal-200 hover:border-teal-400 transition-all duration-300 hover:shadow-lg hover:shadow-teal-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-semibold text-teal-700 mb-1">Total Booking</h3>
                                        <p class="text-3xl font-extrabold text-teal-600">{{ number_format($totalBookings) }}</p>
                                    </div>
                                    <div class="p-3 bg-teal-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="group p-5 bg-gradient-to-br from-cyan-50 to-sky-50 rounded-xl border-2 border-cyan-200 hover:border-cyan-400 transition-all duration-300 hover:shadow-lg hover:shadow-cyan-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-semibold text-cyan-700 mb-1">Booking Hari Ini</h3>
                                        <p class="text-3xl font-extrabold text-cyan-600">{{ number_format($bookingsToday) }}</p>
                                    </div>
                                    <div class="p-3 bg-cyan-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="group p-5 bg-gradient-to-br from-sky-50 to-blue-50 rounded-xl border-2 border-sky-200 hover:border-sky-400 transition-all duration-300 hover:shadow-lg hover:shadow-sky-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-semibold text-sky-700 mb-1">Booking Bulan Ini</h3>
                                        <p class="text-3xl font-extrabold text-sky-600">{{ number_format($bookingsThisMonth) }}</p>
                                    </div>
                                    <div class="p-3 bg-sky-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Affiliate & Property Stats -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-gradient-to-br from-emerald-500 to-green-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">Ringkasan Lainnya</h4>
                                <p class="text-sm text-gray-500">Data affiliate & properti</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="group p-5 bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl border-2 border-emerald-200 hover:border-emerald-400 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-semibold text-emerald-700 mb-1">Affiliate Aktif</h3>
                                        <p class="text-3xl font-extrabold text-emerald-600">{{ number_format($activeAffiliates) }}</p>
                                    </div>
                                    <div class="p-3 bg-emerald-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="group p-5 bg-gradient-to-br from-yellow-50 to-amber-50 rounded-xl border-2 border-yellow-200 hover:border-yellow-400 transition-all duration-300 hover:shadow-lg hover:shadow-yellow-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-semibold text-yellow-700 mb-1">Affiliate Pending</h3>
                                        <p class="text-3xl font-extrabold text-yellow-600">{{ number_format($pendingAffiliates) }}</p>
                                    </div>
                                    <div class="p-3 bg-yellow-200/50 rounded-lg group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="group p-4 bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl border-2 border-gray-200 hover:border-gray-400 transition-all duration-300">
                                    <h3 class="text-xs font-semibold text-gray-700 mb-2">Tipe Kamar</h3>
                                    <p class="text-2xl font-extrabold text-gray-600">{{ $roomCount }}</p>
                                </div>
                                <div class="group p-4 bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl border-2 border-gray-200 hover:border-gray-400 transition-all duration-300">
                                    <h3 class="text-xs font-semibold text-gray-700 mb-2">Ruang MICE</h3>
                                    <p class="text-2xl font-extrabold text-gray-600">{{ $miceCount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart: Last 7 Days -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-800">Tren Kunjungan 7 Hari Terakhir</h4>
                            <p class="text-sm text-gray-500">Analisis performa harian</p>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">Tanggal</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">Kunjungan Website</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">Klik Affiliate</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($last7Days as $day)
                                <tr class="hover:bg-admin-primary/5 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ $day['date'] }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-gradient-to-r from-admin-primary/20 to-admin-secondary/20 text-admin-secondary border border-admin-primary/30">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            {{ number_format($day['website_visits']) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-bold bg-gradient-to-r from-orange-100 to-amber-100 text-orange-700 border border-orange-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                            {{ number_format($day['affiliate_clicks']) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Performing Affiliates -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top by Clicks -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-gradient-to-br from-orange-500 to-amber-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">Top 5 Affiliate (Berdasarkan Klik)</h4>
                                <p class="text-sm text-gray-500">Affiliate terbaik berdasarkan klik link</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @forelse($topAffiliatesByClicks as $index => $affiliate)
                            <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-orange-50/50 to-amber-50/50 rounded-xl border-2 border-orange-200 hover:border-orange-400 transition-all duration-300 hover:shadow-lg hover:shadow-orange-100">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gradient-to-br from-orange-500 to-amber-600 text-white font-bold shadow-lg shadow-orange-300/50 group-hover:scale-110 transition-transform duration-300">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $affiliate->user->name }}</p>
                                        <p class="text-xs text-gray-500 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            {{ $affiliate->user->email }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-extrabold text-orange-600">{{ number_format($affiliate->total_clicks) }}</p>
                                    <p class="text-xs text-gray-500 font-medium">klik</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                <p class="text-gray-500 font-medium">Belum ada data affiliate.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Top by Bookings -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="p-6">
                        <div class="flex items-center space-x-3 mb-6">
                            <div class="p-2 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-gray-800">Top 5 Affiliate (Berdasarkan Booking)</h4>
                                <p class="text-sm text-gray-500">Affiliate terbaik berdasarkan booking</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @forelse($topAffiliatesByBookings as $index => $affiliate)
                            <div class="group flex items-center justify-between p-4 bg-gradient-to-r from-teal-50/50 to-cyan-50/50 rounded-xl border-2 border-teal-200 hover:border-teal-400 transition-all duration-300 hover:shadow-lg hover:shadow-teal-100">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-gradient-to-br from-teal-500 to-cyan-600 text-white font-bold shadow-lg shadow-teal-300/50 group-hover:scale-110 transition-transform duration-300">
                                            {{ $index + 1 }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $affiliate->user->name }}</p>
                                        <p class="text-xs text-teal-700 font-semibold mt-1">
                                            Komisi: Rp {{ number_format($affiliate->total_commission ?? 0) }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xl font-extrabold text-teal-600">{{ number_format($affiliate->total_bookings) }}</p>
                                    <p class="text-xs text-gray-500 font-medium">booking</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                <p class="text-gray-500 font-medium">Belum ada data affiliate.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>