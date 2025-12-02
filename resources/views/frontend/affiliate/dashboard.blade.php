@extends('layouts.frontend')

@section('seo_title', 'Affiliate Dashboard - Sora Hotel Merauke')

@section('content')
    {{-- 1. HERO & STATS SECTION --}}
    <div class="relative bg-brand-dark pt-32 pb-40 overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-brand-secondary rounded-full opacity-10 blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-brand-primary rounded-full opacity-20 blur-3xl"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            {{-- Header Bar: Judul & Tombol Logout --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-4">
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="inline-block py-1 px-3 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-brand-secondary tracking-[0.2em] uppercase text-xs font-bold mb-4">
                                Affiliate Portal
                            </span>
                            <h1 class="text-3xl md:text-5xl font-heading font-bold text-white leading-tight">
                                Halo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-secondary to-blue-300">{{ Auth::user()->name }}</span>
                            </h1>
                            <p class="text-blue-100 text-lg mt-4 max-w-2xl font-light">
                                Pantau performa, cek komisi, dan kelola link referral Anda dalam satu tempat.
                            </p>
                        </div>
                        
                        {{-- TOMBOL LOGOUT (Desktop) --}}
                        <form method="POST" action="{{ route('logout') }}" class="hidden md:block">
                            @csrf
                            <button type="submit" class="text-blue-200 hover:text-white text-sm font-medium flex items-center gap-2 transition-all border border-white/10 hover:border-white/30 px-5 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 backdrop-blur-sm">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="flex flex-wrap gap-4 mb-10">
                <a href="{{ route('affiliate.bookings.create') }}" class="inline-flex items-center gap-2 bg-brand-secondary hover:bg-white hover:text-brand-primary text-white font-bold py-3 px-6 rounded-xl transition-all shadow-lg shadow-brand-secondary/20 transform hover:-translate-y-1">
                    <i class="fas fa-bed"></i> Booking Kamar
                </a>

                <a href="{{ route('affiliate.special-mice.show', 6) }}" class="inline-flex items-center gap-2 bg-white/10 hover:bg-white hover:text-brand-dark text-white font-bold py-3 px-6 rounded-xl transition-all border border-white/10 backdrop-blur-sm">
                    <i class="fas fa-handshake"></i> Booking MICE
                </a>
                
                <a href="{{ route('affiliate.mice-kit.index') }}" class="inline-flex items-center gap-2 bg-transparent hover:bg-white/10 text-blue-200 hover:text-white font-bold py-3 px-6 rounded-xl transition-all border border-white/20">
                    <i class="fas fa-book-open"></i> Katalog
                </a>

                {{-- Mobile Logout --}}
                <form method="POST" action="{{ route('logout') }}" class="md:hidden w-full mt-2">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 font-bold py-3 px-6 rounded-xl transition-all border border-red-500/30">
                        <i class="fas fa-sign-out-alt"></i> Keluar Akun
                    </button>
                </form>
            </div>

            {{-- Stats Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Card 1: Clicks --}}
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 flex items-center gap-5 group hover:bg-white/10 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-mouse-pointer text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs uppercase font-bold tracking-widest mb-1">Total Klik</p>
                        <h3 class="text-4xl font-heading font-bold text-white">{{ number_format($totalClicks ?? 0) }}</h3>
                    </div>
                </div>

                {{-- Card 2: Bookings --}}
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 flex items-center gap-5 group hover:bg-white/10 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-400 to-teal-600 flex items-center justify-center text-white shadow-lg shadow-teal-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs uppercase font-bold tracking-widest mb-1">Booking Sukses</p>
                        <h3 class="text-4xl font-heading font-bold text-white">{{ number_format($totalBookings ?? 0) }}</h3>
                    </div>
                </div>

                {{-- Card 3: Commissions --}}
                <div class="bg-white/5 backdrop-blur-md border border-white/10 rounded-3xl p-6 flex items-center gap-5 group hover:bg-white/10 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-accent to-yellow-600 flex items-center justify-center text-white shadow-lg shadow-yellow-500/30 group-hover:scale-110 transition-transform">
                        <i class="fas fa-wallet text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-blue-200 text-xs uppercase font-bold tracking-widest mb-1">Komisi (Unpaid)</p>
                        <h3 class="text-3xl font-heading font-bold text-white">Rp {{ number_format($totalCommissions ?? 0, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. REFERRAL LINK & HISTORY --}}
    <div class="bg-brand-light py-16 -mt-24 relative z-20 rounded-t-[3rem]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Referral Link Card --}}
            <div class="bg-white rounded-[2rem] shadow-xl p-8 md:p-10 border border-gray-100 mb-12 relative overflow-hidden transform -translate-y-16">
                <div class="absolute top-0 right-0 w-64 h-64 bg-brand-secondary/10 rounded-full blur-3xl -mr-20 -mt-20"></div>
                
                <div class="relative z-10">
                    <h3 class="text-xl font-bold text-brand-dark mb-3 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-brand-secondary/20 flex items-center justify-center">
                            <i class="fas fa-link text-brand-secondary text-sm"></i>
                        </div>
                        Link Referral Anda
                    </h3>
                    <p class="text-gray-500 text-base mb-6 max-w-2xl">Bagikan link ini ke media sosial atau calon tamu. Setiap booking yang sukses melalui link ini akan memberikan Anda komisi.</p>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="relative flex-grow group">
                            <input type="text" id="referralLink" 
                                   value="{{ route('home') }}/?ref={{ Auth::user()->affiliate->referral_code ?? '' }}" 
                                   class="w-full bg-gray-50 border border-gray-200 text-brand-dark text-sm rounded-xl focus:ring-brand-secondary focus:border-brand-secondary block p-4 pr-12 font-mono transition-all group-hover:bg-white group-hover:shadow-md" readonly>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <i class="fas fa-globe text-gray-400"></i>
                            </div>
                        </div>
                        <button onclick="copyLink()" class="bg-brand-dark hover:bg-brand-primary text-white font-bold py-4 px-8 rounded-xl transition-all shadow-lg shadow-brand-dark/20 flex items-center justify-center gap-2 sm:w-auto w-full transform hover:-translate-y-0.5">
                            <i class="far fa-copy"></i> <span>Salin Link</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Commission History Table --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="text-xl font-bold text-brand-dark">Riwayat Komisi Terbaru</h3>
                    <span class="text-xs bg-blue-50 text-brand-secondary px-4 py-2 rounded-full font-bold uppercase tracking-wider">
                        5 Transaksi Terakhir
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-50/50 border-b border-gray-100 font-bold tracking-wider">
                            <tr>
                                <th class="px-8 py-5">Tanggal</th>
                                <th class="px-8 py-5">Keterangan / Tamu</th>
                                <th class="px-8 py-5">Nominal</th>
                                <th class="px-8 py-5 text-center">Status</th>
                                <th class="px-8 py-5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($commissions ?? [] as $commission)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="px-8 py-5 text-gray-600 font-medium">
                                    {{ $commission->created_at->format('d M Y') }}
                                    <br><span class="text-xs text-gray-400 font-normal">{{ $commission->created_at->format('H:i') }}</span>
                                </td>
                                <td class="px-8 py-5">
                                    @if($commission->booking)
                                        <div class="font-bold text-brand-dark">{{ $commission->booking->guest_name }}</div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-2">
                                            @if($commission->booking->mice_kit_id)
                                                <span class="text-purple-600 bg-purple-50 px-2 py-0.5 rounded text-[0.65rem] font-bold uppercase">MICE</span>
                                            @elseif($commission->booking->room_id)
                                                <span class="text-brand-secondary bg-blue-50 px-2 py-0.5 rounded text-[0.65rem] font-bold uppercase">ROOM</span>
                                            @endif
                                            <span class="font-mono text-gray-400">#{{ $commission->booking->booking_code ?? $commission->booking->id }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Booking dihapus</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 font-bold text-green-600 text-base">
                                    + Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-8 py-5 text-center">
                                    @if($commission->status == 'paid')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                            PAID
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                                            UNPAID
                                        </span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-center">
                                    <button type="button" 
                                        onclick="showDetail(this)"
                                        data-date="{{ $commission->created_at->format('d F Y H:i') }}"
                                        data-guest="{{ $commission->booking->guest_name ?? '-' }}"
                                        data-total="Rp {{ number_format($commission->booking->total_price ?? 0, 0, ',', '.') }}"
                                        data-commission="Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}"
                                        data-rate="{{ $commission->rate }}%"
                                        data-note="{{ $commission->notes ?? '-' }}"
                                        class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:bg-brand-secondary hover:text-white transition-all flex items-center justify-center"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center text-gray-400 bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                            <i class="fas fa-inbox text-2xl"></i>
                                        </div>
                                        <p class="font-medium">Belum ada riwayat komisi.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if(isset($commissions) && $commissions->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50/30">
                    {{ $commissions->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>

    {{-- MODAL DETAIL --}}
    <div id="detailModal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-brand-dark/80 transition-opacity backdrop-blur-sm" onclick="closeModal()"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                
                {{-- Modal Header --}}
                <div class="bg-brand-dark px-6 py-5 flex justify-between items-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-brand-secondary/20 to-transparent"></div>
                    <h3 class="text-lg font-bold leading-6 text-white relative z-10" id="modal-title">Detail Transaksi</h3>
                    <button type="button" onclick="closeModal()" class="text-white/50 hover:text-white transition-colors relative z-10">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="px-6 py-8">
                    <div class="space-y-6">
                        <div class="text-center pb-6 border-b border-gray-100">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Komisi Anda</span>
                            <p class="text-4xl font-heading font-bold text-green-600 mt-2" id="modalCommission">Rp 0</p>
                        </div>

                        <div class="grid grid-cols-2 gap-6 text-sm">
                            <div>
                                <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Tanggal</span>
                                <span class="font-bold text-brand-dark text-base" id="modalDate">-</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Nama Tamu</span>
                                <span class="font-bold text-brand-dark text-base" id="modalGuest">-</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Total Transaksi</span>
                                <span class="font-bold text-brand-dark text-base" id="modalTotal">-</span>
                            </div>
                            <div>
                                <span class="block text-xs text-gray-400 mb-1 uppercase tracking-wider font-bold">Rate Komisi</span>
                                <span class="font-bold text-brand-dark text-base" id="modalRate">-</span>
                            </div>
                        </div>

                        <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                            <span class="block text-xs text-blue-600 mb-1 font-bold uppercase">Catatan Sistem</span>
                            <p class="text-sm text-gray-700 italic" id="modalNote">-</p>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="inline-flex w-full justify-center rounded-xl bg-white px-5 py-3 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto transition-all">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Fungsi Copy Link
        function copyLink() {
            var copyText = document.getElementById("referralLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999); // Untuk Mobile
            navigator.clipboard.writeText(copyText.value).then(() => {
                // Bisa ganti alert dengan toast notification yang lebih bagus jika ada librarynya
                alert("Link berhasil disalin!");
            });
        }

        // Fungsi Modal Detail
        function showDetail(button) {
            // Ambil data dari atribut
            const date = button.getAttribute('data-date');
            const guest = button.getAttribute('data-guest');
            const total = button.getAttribute('data-total');
            const commission = button.getAttribute('data-commission');
            const rate = button.getAttribute('data-rate');
            const note = button.getAttribute('data-note');

            // Isi ke dalam modal
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalGuest').innerText = guest;
            document.getElementById('modalTotal').innerText = total;
            document.getElementById('modalCommission').innerText = commission;
            document.getElementById('modalRate').innerText = rate;
            document.getElementById('modalNote').innerText = note;

            // Tampilkan modal (Hapus class hidden)
            document.getElementById('detailModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('detailModal').classList.add('hidden');
        }
    </script>
    @endpush
@endsection 

