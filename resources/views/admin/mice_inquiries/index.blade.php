<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
            {{ __('Log MICE Affiliate Commission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Sesi untuk notifikasi sukses atau error --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Card Formulir Pencatatan --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 mb-8">
                <div class="p-8 bg-white border-b border-gray-100">
                    <h3 class="text-xl font-heading font-bold text-brand-dark mb-6 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-brand-primary"></i> Add New MICE Commission
                    </h3>
                    <form action="{{ route('admin.mice-inquiries.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            {{-- Kolom Kiri --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="event_name" class="block font-bold text-sm text-gray-700 mb-2">Nama Kegiatan</label>
                                    <input type="text" name="event_name" id="event_name" value="{{ old('event_name') }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" required placeholder="Contoh: Seminar Nasional">
                                </div>
                                <div>
                                    <label for="mice_room_id" class="block font-bold text-sm text-gray-700 mb-2">Ruangan MICE</label>
                                    <select name="mice_room_id" id="mice_room_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" required>
                                        <option value="">-- Pilih Ruangan --</option>
                                        @foreach($miceRooms as $room)
                                            <option value="{{ $room->id }}" {{ old('mice_room_id') == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="event_date" class="block font-bold text-sm text-gray-700 mb-2">Tanggal Kegiatan</label>
                                    <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" required>
                                </div>
                            </div>

                            {{-- Kolom Kanan --}}
                            <div class="space-y-6">
                                <div>
                                    <label for="affiliate-select" class="block font-bold text-sm text-gray-700 mb-2">Pilih Affiliate</label>
                                    {{-- INI BAGIAN YANG DIPERBARUI --}}
                                    <select name="user_id" id="affiliate-select" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" style="width: 100%;" required>
                                        <option value="">-- Cari atau Pilih Affiliate --</option>
                                        @foreach($affiliates as $affiliateUser)
                                            <option value="{{ $affiliateUser->id }}" {{ old('user_id') == $affiliateUser->id ? 'selected' : '' }}>
                                                {{ $affiliateUser->name }} ({{ $affiliateUser->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="total_payment" class="block font-bold text-sm text-gray-700 mb-2">Total Pembayaran (Rp)</label>
                                    <input type="number" name="total_payment" id="total_payment" value="{{ old('total_payment') }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all" placeholder="Contoh: 5000000" required>
                                </div>
                                <div class="p-6 bg-green-50 rounded-2xl border border-green-100">
                                    <h4 class="font-bold text-green-800 text-sm uppercase tracking-wide">Perhitungan Komisi (2.5%)</h4>
                                    <p class="text-3xl font-bold text-green-600 mt-2" id="commission-display">Rp 0</p>
                                </div>
                            </div>
                        </div>
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="px-8 py-3 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i class="fas fa-save"></i> Save Commission
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Card Riwayat Komisi MICE (Tidak ada perubahan di sini) --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 bg-white border-b border-gray-100">
                    <h3 class="text-xl font-heading font-bold text-brand-dark mb-6 flex items-center gap-2">
                        <i class="fas fa-history text-brand-primary"></i> MICE Commission History
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Affiliate</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Detail Event</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Commission</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date Recorded</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse ($miceCommissions as $commission)
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-brand-dark">{{ $commission->affiliate->user->name ?? 'N/A' }}</div>
                                            <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                                <i class="fas fa-envelope text-[10px]"></i> {{ $commission->affiliate->user->email ?? '' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-pre-wrap text-sm text-gray-700">{!! nl2br(e($commission->notes)) !!}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-emerald-600">Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}</div>
                                            <div class="text-xs text-gray-500 font-mono">({{ $commission->rate }}%)</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $commission->created_at->format('d F Y, H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('admin.mice-inquiries.destroy', $commission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-file-invoice-dollar text-4xl text-gray-200 mb-3"></i>
                                                <p>No MICE commissions recorded yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
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
                allowClear: true,
                width: '100%' // Ensure full width
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
