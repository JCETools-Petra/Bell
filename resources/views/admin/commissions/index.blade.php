<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
            {{ __('Commission Payouts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="mb-6 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-500 mt-0.5"></i>
                        <p class="text-sm text-blue-700">Halaman ini menampilkan ringkasan komisi yang belum dibayar per-affiliate. Klik "View Details & Pay" untuk melihat rincian dan melakukan pembayaran.</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Affiliate Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Referral Code</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Unpaid Amount</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse ($affiliates as $affiliate)
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{-- PERBAIKAN 1: Periksa apakah user ada --}}
                                            @if ($affiliate->user)
                                                <div class="font-bold text-brand-dark">{{ $affiliate->user->name }}</div>
                                                <div class="text-sm text-gray-500 flex items-center gap-1 mt-0.5">
                                                    <i class="fas fa-envelope text-xs"></i> {{ $affiliate->user->email }}
                                                </div>
                                            @else
                                                <div class="font-bold text-brand-red">User Deleted</div>
                                                <div class="text-sm text-gray-500">Affiliate ID: {{ $affiliate->id }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 font-mono text-xs font-bold bg-gray-100 text-gray-700 rounded border border-gray-200">{{ $affiliate->referral_code }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-bold text-lg text-emerald-600">
                                            {{-- PERBAIKAN 2: Beri nilai default 0 jika unpaid_amount null --}}
                                            Rp {{ number_format($affiliate->unpaid_amount ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button 
                                                class="px-4 py-2 bg-brand-primary text-white rounded-xl shadow-lg shadow-brand-primary/20 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none flex items-center gap-2 ml-auto"
                                                {{-- PERBAIKAN 3: Periksa user sebelum memanggil onclick --}}
                                                @if($affiliate->user)
                                                    onclick="openCommissionModal({{ $affiliate->id }}, '{{ addslashes($affiliate->user->name) }}')"
                                                @endif
                                                {{ ($affiliate->unpaid_amount ?? 0) > 0 ? '' : 'disabled' }}>
                                                <i class="fas fa-wallet"></i> View Details & Pay
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-check-circle text-4xl text-green-200 mb-3"></i>
                                                <p>No affiliates with unpaid commissions.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="commissionModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50" style="display: none;">
        <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-3xl shadow-2xl rounded-2xl bg-white overflow-hidden transform transition-all">
            <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-heading font-bold text-brand-dark" id="modalTitle">Commission Details</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center transition-colors" onclick="closeCommissionModal()">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            <div class="p-6">
                <div class="max-h-96 overflow-y-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Source</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="commissionDetailsBody" class="divide-y divide-gray-50">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50/50 flex justify-end">
                <form id="payForm" method="POST">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fas fa-check-double"></i> Mark All as Paid
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCommissionModal(affiliateId, affiliateName) {
            document.getElementById('modalTitle').innerText = 'Unpaid Commissions for ' + affiliateName;
            
            // Set the form action
            const payForm = document.getElementById('payForm');
            if (payForm) {
                payForm.action = '/admin/commissions/' + affiliateId + '/pay';
            }
    
            // Fetch commission details via AJAX
            fetch('/admin/commissions/' + affiliateId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let tableBody = document.getElementById('commissionDetailsBody');
                    tableBody.innerHTML = ''; // Clear previous data
                    if (data.length > 0) {
                        data.forEach(commission => {
                            
                            // --- PERBAIKAN LOGIKA TAMPILAN DIMULAI DI SINI ---
    
                            let detailHtml = '';
                            // Periksa jika ini komisi booking kamar (ada booking_id)
                            if (commission.booking_id && commission.booking) {
                                detailHtml = `<div class="font-medium text-gray-900">Booking #${commission.booking_id}</div><div class="text-xs text-gray-500">${commission.booking.room ? commission.booking.room.name : 'Room Deleted'}</div>`;
                            } 
                            // Jika tidak, ini komisi MICE (gunakan notes)
                            else if (commission.notes) {
                                // Parsing sederhana dari notes
                                const lines = commission.notes.split('\\n');
                                const eventName = lines[0] ? lines[0].replace('MICE Event: ', '') : 'MICE Event';
                                const roomName = lines[1] ? lines[1].replace('Room: ', '') : '';
                                detailHtml = `<div class="font-medium text-gray-900">${eventName}</div><div class="text-xs text-gray-500">${roomName}</div>`;
                            } 
                            // Fallback jika tidak ada keduanya
                            else {
                                detailHtml = '<span class="text-gray-600 italic">Manual Commission</span>';
                            }
    
                            // Perbaiki referensi ke 'commission_amount'
                            const commissionAmount = parseInt(commission.commission_amount).toLocaleString('id-ID');
    
                            let row = `<tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">${detailHtml}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">${new Date(commission.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</td>
                                <td class="px-4 py-3 font-bold text-emerald-600">Rp ${commissionAmount}</td>
                            </tr>`;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-8 text-gray-500">No unpaid commissions for this month.</td></tr>';
                    }
                    document.getElementById('commissionModal').style.display = 'block';
                    document.body.style.overflow = 'hidden'; // Prevent background scrolling
                })
                .catch(error => {
                    console.error('Failed to fetch commission details:', error);
                    let tableBody = document.getElementById('commissionDetailsBody');
                    tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-8 text-red-500"><i class="fas fa-exclamation-triangle mb-2"></i><br>Failed to load details.</td></tr>';
                    document.getElementById('commissionModal').style.display = 'block';
                });
        }
    
        function closeCommissionModal() {
            document.getElementById('commissionModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('commissionModal');
            if (event.target == modal) {
                closeCommissionModal();
            }
        }
    </script>
</x-app-layout>
