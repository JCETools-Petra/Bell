<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Commission Payouts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <p class="text-gray-600 mb-4">Halaman ini menampilkan ringkasan komisi yang belum dibayar per-affiliate. Klik "View Details & Pay" untuk melihat rincian dan melakukan pembayaran.</p>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Affiliate Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Referral Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unpaid Amount</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($affiliates as $affiliate)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $affiliate->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-mono">{{ $affiliate->referral_code }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-lg">
                                        Rp {{ number_format($affiliate->unpaid_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <button 
                                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition disabled:opacity-50"
                                            onclick="openCommissionModal({{ $affiliate->id }}, '{{ $affiliate->user->name }}')"
                                            {{ $affiliate->unpaid_amount > 0 ? '' : 'disabled' }}>
                                            View Details & Pay
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No affiliates with unpaid commissions.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="commissionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" style="display: none;">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Commission Details</h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center" onclick="closeCommissionModal()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
            <div class="mt-3">
                <div class="max-h-96 overflow-y-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody id="commissionDetailsBody">
                            </tbody>
                    </table>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t flex justify-end">
                <form id="payForm" method="POST">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Mark All as Paid</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCommissionModal(affiliateId, affiliateName) {
            document.getElementById('modalTitle').innerText = 'Unpaid Commissions for ' + affiliateName + ' (This Month)';
            
            // Set the form action
            document.getElementById('payForm').action = '/admin/commissions/' + affiliateId + '/pay';

            // Fetch commission details via AJAX
            fetch('/admin/commissions/' + affiliateId)
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.getElementById('commissionDetailsBody');
                    tableBody.innerHTML = ''; // Clear previous data
                    if (data.length > 0) {
                        data.forEach(commission => {
                            let row = `<tr>
                                <td class="px-4 py-2">#${commission.booking_id}</td>
                                <td class="px-4 py-2">${new Date(commission.created_at).toLocaleDateString()}</td>
                                <td class="px-4 py-2">Rp ${parseInt(commission.amount).toLocaleString('id-ID')}</td>
                            </tr>`;
                            tableBody.innerHTML += row;
                        });
                    } else {
                        tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-4">No unpaid commissions for this month.</td></tr>';
                    }
                    document.getElementById('commissionModal').style.display = 'block';
                });
        }

        function closeCommissionModal() {
            document.getElementById('commissionModal').style.display = 'none';
        }
    </script>
</x-app-layout>