<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">
                    {{ __('Log MICE Affiliate Commission') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Catat komisi MICE untuk affiliate</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Sesi untuk notifikasi sukses atau error --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-rose-50 border-l-4 border-red-500 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-red-700 font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            {{-- Card Formulir Pencatatan --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent mb-4">Add New MICE Commission</h3>
                    <form action="{{ route('admin.mice-inquiries.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- Kolom Kiri --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="event_name" class="block text-sm font-medium text-gray-700">Nama Kegiatan</label>
                                    <input type="text" name="event_name" id="event_name" value="{{ old('event_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>
                                <div>
                                    <label for="mice_room_id" class="block text-sm font-medium text-gray-700">Ruangan MICE</label>
                                    <select name="mice_room_id" id="mice_room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                        <option value="">-- Pilih Ruangan --</option>
                                        @foreach($miceRooms as $room)
                                            <option value="{{ $room->id }}" {{ old('mice_room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="event_date" class="block text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
                                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="space-y-4">
                                <div>
                                    <label for="affiliate-select" class="block text-sm font-medium text-gray-700">Pilih Affiliate</label>
                                    {{-- INI BAGIAN YANG DIPERBARUI --}}
                                    <select name="user_id" id="affiliate-select" class="mt-1 block w-full" style="width: 100%;" required>
                                        <option value="">-- Cari atau Pilih Affiliate --</option>
                                        @foreach($affiliates as $affiliateUser)
                                            <option value="{{ $affiliateUser->id }}" {{ old('user_id') == $affiliateUser->id ? 'selected' : '' }}>
                                                {{ $affiliateUser->name }} ({{ $affiliateUser->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="total_payment" class="block text-sm font-medium text-gray-700">Total Pembayaran (Rp)</label>
                                    <input type="number" name="total_payment" id="total_payment" value="{{ old('total_payment') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: 5000000" required>
                                </div>
                                <div class="p-4 bg-gray-50 rounded-lg">
                                    <h4 class="font-semibold text-gray-800">Perhitungan Komisi (2.5%)</h4>
                                    <p class="text-2xl font-bold text-green-600 mt-2" id="commission-display">Rp 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-admin-primary to-admin-secondary text-white rounded-lg hover:shadow-lg hover:shadow-admin-primary/50 transition-all duration-300 font-medium">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Save Commission
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Card Riwayat Komisi MICE (Tidak ada perubahan di sini) --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent mb-4">MICE Commission History</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            <span>Affiliate</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            <span>Detail Event</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>Commission</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span>Date Recorded</span>
                                        </div>
                                    </th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-admin-secondary uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($miceCommissions as $commission)
                                    <tr class="hover:bg-admin-primary/5 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="font-semibold text-gray-900">{{ $commission->affiliate->user->name ?? 'N/A' }}</div>
                                            <div class="text-sm text-gray-500">{{ $commission->affiliate->user->email ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{!! nl2br(e($commission->notes)) !!}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-admin-secondary font-bold">Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}</div>
                                            <div class="text-sm text-gray-500">({{ $commission->rate }}%)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $commission->created_at->format('d F Y, H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.mice-inquiries.destroy', $commission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:shadow-lg hover:shadow-red-500/50 transition-all duration-300">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                                <p class="text-gray-500 font-medium text-lg">No MICE commissions recorded yet</p>
                                                <p class="text-gray-400 text-sm mt-2">Add commissions using the form above</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $miceCommissions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    {{-- Script untuk Select2 --}}
    <script>
        $(document).ready(function() {
            $('#affiliate-select').select2({
                placeholder: "Cari nama atau email affiliate",
                allowClear: true
            });
        });
    </script>

    {{-- Script untuk Kalkulasi Komisi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const totalPaymentInput = document.getElementById('total_payment');
            const commissionDisplay = document.getElementById('commission-display');
            const commissionRate = 0.025; // 2.5%

            function calculateCommission() {
                const totalPayment = parseFloat(totalPaymentInput.value) || 0;
                const commission = totalPayment * commissionRate;
                
                // Format ke format Rupiah
                commissionDisplay.textContent = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(commission);
            }

            totalPaymentInput.addEventListener('input', calculateCommission);
            
            // Hitung saat halaman dimuat jika ada old value
            if (totalPaymentInput.value) {
                calculateCommission();
            }
        });
    </script>
    @endpush
</x-app-layout>