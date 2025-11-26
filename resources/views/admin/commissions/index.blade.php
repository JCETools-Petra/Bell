<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">
                    {{ __('Commission Payouts') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola pembayaran komisi affiliate</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 rounded-lg shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-green-700 font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6 overflow-x-auto">
                    <p class="text-gray-600 mb-6 text-sm">Halaman ini menampilkan ringkasan komisi yang belum dibayar per-affiliate. Klik "View Details & Pay" untuk melihat rincian dan melakukan pembayaran.</p>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span>Affiliate Name</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                        <span>Referral Code</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Unpaid Amount</span>
                                    </div>
                                </th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-admin-secondary uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($affiliates as $affiliate)
                                <tr class="hover:bg-admin-primary/5 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- PERBAIKAN 1: Periksa apakah user ada --}}
                                        @if ($affiliate->user)
                                            <div class="font-semibold text-gray-900">{{ $affiliate->user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $affiliate->user->email }}</div>
                                        @else
                                            <div class="font-semibold text-red-600">User Deleted</div>
                                            <div class="text-sm text-gray-500">Affiliate ID: {{ $affiliate->id }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-mono font-semibold bg-gradient-to-r from-purple-100 to-violet-100 text-purple-700 border border-purple-200">
                                            {{ $affiliate->referral_code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- PERBAIKAN 2: Beri nilai default 0 jika unpaid_amount null --}}
                                        <span class="text-admin-secondary font-bold text-lg">Rp {{ number_format($affiliate->unpaid_amount ?? 0, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-admin-primary to-admin-secondary text-white rounded-lg hover:shadow-lg hover:shadow-admin-primary/50 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
                                            {{-- PERBAIKAN 3: Periksa user sebelum memanggil onclick --}}
                                            @if($affiliate->user)
                                                onclick="openCommissionModal({{ $affiliate->id }}, '{{ addslashes($affiliate->user->name) }}')"
                                            @endif
                                            {{ ($affiliate->unpaid_amount ?? 0) > 0 ? '' : 'disabled' }}>
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            View Details & Pay
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            <p class="text-gray-500 font-medium text-lg">No affiliates with unpaid commissions</p>
                                            <p class="text-gray-400 text-sm mt-2">Commissions will appear here when affiliates earn rewards</p>
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

    <div id="commissionModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50" style="display: none;">
        <div class="relative top-20 mx-auto p-6 border border-gray-200 w-full max-w-3xl shadow-2xl rounded-2xl bg-white">
            <div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-4">
                <h3 class="text-xl font-bold bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent" id="modalTitle">Commission Details</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-100 hover:text-gray-900 rounded-lg text-sm p-2 inline-flex items-center transition-colors" onclick="closeCommissionModal()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div class="mt-4">
                <div class="max-h-96 overflow-y-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10 sticky top-0">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-admin-secondary uppercase">Booking ID</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-admin-secondary uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-admin-secondary uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="commissionDetailsBody" class="bg-white divide-y divide-gray-100">
                            </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end">
                <form id="payForm" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-lg hover:shadow-lg hover:shadow-green-500/50 transition-all duration-300 font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Mark All as Paid
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCommissionModal(affiliateId, affiliateName) {
            document.getElementById('modalTitle').innerText = 'Unpaid Commissions for ' + affiliateName + ' (This Month)';
            
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
                                detailHtml = `<strong>Booking ID #${commission.booking_id}</strong><br><small>${commission.booking.room ? commission.booking.room.name : 'Room Deleted'}</small>`;
                            } 
                            // Jika tidak, ini komisi MICE (gunakan notes)
                            else if (commission.notes) {
                                // Parsing sederhana dari notes
                                const lines = commission.notes.split('\\n');
                                const eventName = lines[0] ? lines[0].replace('MICE Event: ', '') : 'MICE Event';
                                const roomName = lines[1] ? lines[1].replace('Room: ', '') : '';
                                detailHtml = `<strong>${eventName}</strong><br><small>${roomName}</small>`;
                            } 
                            // Fallback jika tidak ada keduanya
                            else {
                                detailHtml = 'Manual Commission';
                            }
    
                            // Perbaiki referensi ke 'commission_amount'
                            const commissionAmount = parseInt(commission.commission_amount).toLocaleString('id-ID');
    
                            let row = `<tr>
                                <td class="px-4 py-3">${detailHtml}</td>
                                <td class="px-4 py-3">${new Date(commission.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })}</td>
                                <td class="px-4 py-3 font-semibold">Rp ${commissionAmount}</td>
                            </tr>`;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-4">No unpaid commissions for this month.</td></tr>';
                    }
                    document.getElementById('commissionModal').style.display = 'block';
                })
                .catch(error => {
                    console.error('Failed to fetch commission details:', error);
                    let tableBody = document.getElementById('commissionDetailsBody');
                    tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-4 text-red-500">Failed to load details.</td></tr>';
                    document.getElementById('commissionModal').style.display = 'block';
                });
        }
    
        function closeCommissionModal() {
            document.getElementById('commissionModal').style.display = 'none';
        }
    </script>
</x-app-layout>