<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">
                    {{ __('Pengaturan Harga Khusus') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Atur harga khusus untuk tanggal tertentu</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            {{-- Form untuk Menambah/Mengubah Harga --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent border-b border-gray-200 pb-3 mb-4">Tambah Harga Khusus</h3>
                <form action="{{ route('admin.price-overrides.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Pilih Tanggal</label>
                            <input type="date" name="date" id="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20" required value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-md font-semibold text-gray-800 mb-2">Masukkan Harga Baru (Rp)</h4>
                        <p class="text-sm text-gray-500 mb-4">Isi harga hanya untuk kamar yang ingin diubah. Biarkan kosong jika ingin menggunakan harga normal.</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach ($rooms as $room)
                                <div>
                                    <label for="price_{{ $room->id }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $room->name }}</label>
                                    <input type="number" name="prices[{{ $room->id }}]" id="price_{{ $room->id }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary/20" placeholder="Normal: {{ number_format($room->price) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-admin-primary to-admin-secondary text-white rounded-lg hover:shadow-lg hover:shadow-admin-primary/50 transition-all duration-300 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Simpan Harga
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tabel Daftar Harga Khusus yang Sudah Ada --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 p-6">
                <h3 class="text-lg font-bold bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent border-b border-gray-200 pb-3 mb-4">Daftar Harga Khusus Aktif</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span>Tanggal</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        <span>Tipe Kamar</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Harga Khusus</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-admin-secondary uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($overrides as $override)
                                <tr class="hover:bg-admin-primary/5 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($override->date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $override->room->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-admin-secondary font-bold">Rp {{ number_format($override->price) }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <form action="{{ route('admin.price-overrides.destroy', $override) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg hover:shadow-red-500/50 transition-all duration-300">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                            <p class="text-gray-500 font-medium text-lg">Belum ada harga khusus yang diatur</p>
                                            <p class="text-gray-400 text-sm mt-2">Tambahkan harga khusus menggunakan form di atas</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $overrides->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
