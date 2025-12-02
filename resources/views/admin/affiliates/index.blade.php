<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Affiliate Management') }}
            </h2>
            <a href="{{ route('admin.commissions.create') }}" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-600/30 hover:bg-green-700 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fas fa-hand-holding-usd"></i> Add Manual Commission
            </a>
        </div>
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
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email & Phone</th>
                                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode Referal</th>
                                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Komisi (%)</th>
                                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-3 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Daftar</th>
                                    <th class="px-3 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse ($affiliates as $affiliate)
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <div class="font-bold text-brand-dark">{{ $affiliate->user->name }}</div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-600">
                                            <div class="flex items-center gap-2"><i class="fas fa-envelope text-gray-400 w-4"></i> {{ $affiliate->user->email }}</div>
                                            <div class="flex items-center gap-2 mt-1"><i class="fas fa-phone text-gray-400 w-4"></i> {{ $affiliate->user->phone }}</div>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 font-mono text-xs font-bold bg-gray-100 text-gray-700 rounded border border-gray-200">{{ $affiliate->referral_code }}</span>
                                        </td>
                                        <form action="{{ route('admin.affiliates.update', $affiliate->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="relative rounded-md shadow-sm">
                                                    <input type="number" step="0.01" name="commission_rate" value="{{ $affiliate->commission_rate }}" class="block w-20 rounded-lg border-gray-300 pl-3 pr-8 focus:border-brand-primary focus:ring-brand-primary sm:text-sm" placeholder="0.00">
                                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                                        <span class="text-gray-500 sm:text-sm">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <select name="status" class="block w-32 rounded-lg border-gray-300 text-sm focus:border-brand-primary focus:ring-brand-primary cursor-pointer">
                                                    <option value="pending" @selected($affiliate->status == 'pending')>Pending</option>
                                                    <option value="active" @selected($affiliate->status == 'active')>Active</option>
                                                    <option value="inactive" @selected($affiliate->status == 'inactive')>Inactive</option>
                                                </select>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $affiliate->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-brand-primary text-white rounded-lg hover:bg-brand-dark transition-all shadow-sm">
                                                    <i class="fas fa-save"></i> Update
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-3 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-users-slash text-4xl text-gray-200 mb-3"></i>
                                                <p>Belum ada pendaftar affiliate.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $affiliates->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>