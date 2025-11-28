<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="font-bold text-2xl bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">
                    {{ __('Activity Logs') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Monitor semua aktivitas Front Office dan Admin</p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Form --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- Search --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search description..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary focus:ring-opacity-50">
                            </div>

                            {{-- Action Filter --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Action Type</label>
                                <select name="action" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary focus:ring-opacity-50">
                                    <option value="">All Actions</option>
                                    @foreach($actions as $action)
                                        <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                            {{ ucwords(str_replace('_', ' ', $action)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- User Filter --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">User</label>
                                <select name="user_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary focus:ring-opacity-50">
                                    <option value="">All Users</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Date From --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                                <input type="date" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary focus:ring-opacity-50">
                            </div>

                            {{-- Date To --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                                <input type="date" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-admin-primary focus:ring focus:ring-admin-primary focus:ring-opacity-50">
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-admin-primary to-admin-secondary text-white rounded-lg hover:shadow-lg transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Filter
                            </button>
                            <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Logs Table --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-admin-primary/10 to-admin-secondary/10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">User</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">Action</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">Description</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-admin-secondary uppercase tracking-wider">Date/Time</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-admin-secondary uppercase tracking-wider">Details</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($logs as $log)
                                <tr class="hover:bg-admin-primary/5 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($log->user)
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-admin-primary to-admin-secondary flex items-center justify-center text-white font-bold">
                                                        {{ substr($log->user->name, 0, 1) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $log->user->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ ucfirst($log->user->role) }}</div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-gray-400 italic">User Deleted</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $actionColors = [
                                                'booking_status_changed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'booking_deleted' => 'bg-red-100 text-red-800 border-red-200',
                                                'booking_cancelled_commission_deleted' => 'bg-orange-100 text-orange-800 border-orange-200',
                                                'commissions_marked_as_paid' => 'bg-green-100 text-green-800 border-green-200',
                                            ];
                                            $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                                            {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($log->description, 80) }}</div>
                                        @if($log->model_type)
                                            <div class="text-xs text-gray-500 mt-1">
                                                {{ $log->model_type }} #{{ $log->model_id }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $log->created_at->format('d M Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->created_at->format('H:i:s') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <a href="{{ route('admin.activity-logs.show', $log) }}" class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-admin-primary to-admin-secondary text-white rounded-lg hover:shadow-lg transition-all duration-300 text-xs">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <p class="text-gray-500 font-medium text-lg">No activity logs found</p>
                                            <p class="text-gray-400 text-sm mt-2">Activity logs will appear here when users perform actions</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $logs->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
