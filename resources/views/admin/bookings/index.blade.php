<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ $title ?? 'All Bookings' }}
            </h2>
            {{-- Tombol Filter Status (Opsional) --}}
            <div class="flex space-x-2">
                <a href="{{ request()->fullUrlWithQuery(['status' => 'pending']) }}" class="px-4 py-1.5 text-xs font-bold rounded-full transition-all shadow-sm {{ request('status') == 'pending' ? 'bg-brand-gold text-white shadow-md transform -translate-y-0.5' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Pending</a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'confirmed']) }}" class="px-4 py-1.5 text-xs font-bold rounded-full transition-all shadow-sm {{ request('status') == 'confirmed' ? 'bg-green-500 text-white shadow-md transform -translate-y-0.5' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">Confirmed</a>
                <a href="{{ route('admin.bookings.index', ['type' => request('type')]) }}" class="px-4 py-1.5 text-xs font-bold rounded-full bg-gray-800 text-white hover:bg-gray-700 transition-all shadow-sm">Reset</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-50 text-red-700 border border-red-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Guest & ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">
                                    {{ request('type') == 'mice' ? 'Event / Package' : 'Room Detail' }}
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Dates</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Price</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($bookings as $booking)
                                <tr class="hover:bg-blue-50/30 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-brand-dark">{{ $booking->guest_name }}</div>
                                        <div class="text-xs text-gray-500 font-mono mt-0.5">#{{ $booking->booking_code ?? $booking->id }}</div>
                                        @if($booking->affiliate)
                                            <div class="text-xs text-brand-secondary mt-1 flex items-center gap-1">
                                                <i class="fas fa-user-tag text-[10px]"></i> Ref: {{ $booking->affiliate->user->name }}
                                            </div>
                                        @endif
                                    </td>
                                    
                                    {{-- Kolom Dinamis (Room vs MICE) --}}
                                    <td class="px-6 py-4">
                                        @if($booking->mice_kit_id)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-purple-100 text-purple-700 mb-1">MICE</span>
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->event_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->miceKit->title ?? 'Deleted Package' }} ({{ $booking->pax }} Pax)</div>
                                        @elseif($booking->room)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide bg-blue-100 text-blue-700 mb-1">ROOM</span>
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->room->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $booking->num_rooms }} Kamar</div>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <div class="flex flex-col gap-1">
                                            <span class="flex items-center gap-2"><i class="fas fa-calendar-check text-green-500 w-4"></i> {{ \Carbon\Carbon::parse($booking->checkin_date)->format('d M Y') }}</span>
                                            @if($booking->checkout_date != $booking->checkin_date)
                                            <span class="flex items-center gap-2"><i class="fas fa-calendar-times text-red-500 w-4"></i> {{ \Carbon\Carbon::parse($booking->checkout_date)->format('d M Y') }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600">
                                        Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColor = match($booking->status) {
                                                'confirmed', 'completed' => 'bg-green-100 text-green-700 border border-green-200',
                                                'cancelled' => 'bg-red-100 text-red-700 border border-red-200',
                                                'awaiting_arrival' => 'bg-blue-100 text-blue-700 border border-blue-200',
                                                default => 'bg-yellow-100 text-yellow-700 border border-yellow-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $statusColor }}">
                                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                        </span>
                                        @if($booking->payment_method == 'pay_at_hotel')
                                            <div class="text-xs text-gray-500 mt-1 italic flex items-center gap-1">
                                                <i class="fas fa-money-bill-wave"></i> Pay at Hotel
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            @if ($booking->status != 'cancelled')
                                                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="status" onchange="if(confirm('Change status?')) this.form.submit()" class="text-xs rounded-lg border-gray-300 shadow-sm focus:border-brand-primary focus:ring focus:ring-brand-primary/20 py-1.5 cursor-pointer hover:border-brand-primary transition-colors">
                                                        <option value="pending" @selected($booking->status == 'pending')>Pending</option>
                                                        <option value="confirmed" @selected($booking->status == 'confirmed')>Confirm</option>
                                                        <option value="cancelled">Cancel</option>
                                                    </select>
                                                    {{-- Hidden input agar filter tidak hilang saat update --}}
                                                    <input type="hidden" name="payment_status" value="{{ $booking->payment_status }}">
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Delete this booking permanently?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-calendar-times text-4xl text-gray-200 mb-3"></i>
                                            <span class="text-lg font-medium text-gray-900">No bookings found</span>
                                            <span class="text-sm text-gray-400 mt-1">Try changing the filter or creating a new booking.</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="mt-6">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
