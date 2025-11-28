<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-gradient-to-br from-admin-primary to-admin-secondary rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="font-bold text-2xl bg-gradient-to-r from-admin-primary to-admin-secondary bg-clip-text text-transparent">
                        Activity Log Details
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Log ID: #{{ $activityLog->id }}</p>
                </div>
            </div>
            <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Logs
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            {{-- Main Info Card --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- User Info --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">User Information</h3>
                            @if($activityLog->user)
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 h-16 w-16">
                                        <div class="h-16 w-16 rounded-full bg-gradient-to-br from-admin-primary to-admin-secondary flex items-center justify-center text-white font-bold text-xl">
                                            {{ substr($activityLog->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-lg font-semibold text-gray-900">{{ $activityLog->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $activityLog->user->email }}</div>
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-admin-primary/10 text-admin-primary">
                                                {{ ucfirst($activityLog->user->role) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-gray-400 italic">User has been deleted</p>
                            @endif
                        </div>

                        {{-- Action Info --}}
                        <div>
                            <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Action Information</h3>
                            <div class="space-y-2">
                                <div>
                                    <span class="text-sm text-gray-500">Action Type:</span>
                                    @php
                                        $actionColors = [
                                            'booking_status_changed' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'booking_deleted' => 'bg-red-100 text-red-800 border-red-200',
                                            'booking_cancelled_commission_deleted' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            'commissions_marked_as_paid' => 'bg-green-100 text-green-800 border-green-200',
                                        ];
                                        $colorClass = $actionColors[$activityLog->action] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    @endphp
                                    <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border {{ $colorClass }}">
                                        {{ ucwords(str_replace('_', ' ', $activityLog->action)) }}
                                    </span>
                                </div>
                                @if($activityLog->model_type)
                                    <div>
                                        <span class="text-sm text-gray-500">Target Model:</span>
                                        <span class="ml-2 font-medium text-gray-900">{{ $activityLog->model_type }} #{{ $activityLog->model_id }}</span>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-sm text-gray-500">Date & Time:</span>
                                    <span class="ml-2 font-medium text-gray-900">{{ $activityLog->created_at->format('d M Y, H:i:s') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Description Card --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-6">
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Description</h3>
                    <p class="text-gray-900 text-base leading-relaxed">{{ $activityLog->description }}</p>
                </div>
            </div>

            {{-- Changes Card --}}
            @if($activityLog->old_values || $activityLog->new_values)
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-6">
                    <div class="p-6">
                        <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">Changes</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Old Values --}}
                            @if($activityLog->old_values)
                                <div>
                                    <h4 class="text-sm font-semibold text-red-600 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Old Values
                                    </h4>
                                    <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                                        <pre class="text-xs text-gray-800 whitespace-pre-wrap">{{ json_encode($activityLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            @endif

                            {{-- New Values --}}
                            @if($activityLog->new_values)
                                <div>
                                    <h4 class="text-sm font-semibold text-green-600 mb-3 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        New Values
                                    </h4>
                                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                                        <pre class="text-xs text-gray-800 whitespace-pre-wrap">{{ json_encode($activityLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Technical Details Card --}}
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-6">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-3">Technical Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-sm text-gray-500">IP Address:</span>
                            <span class="ml-2 font-mono text-sm text-gray-900">{{ $activityLog->ip_address ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="text-sm text-gray-500">Created At:</span>
                            <span class="ml-2 font-mono text-sm text-gray-900">{{ $activityLog->created_at->toDateTimeString() }}</span>
                        </div>
                    </div>
                    @if($activityLog->user_agent)
                        <div class="mt-4">
                            <span class="text-sm text-gray-500">User Agent:</span>
                            <p class="mt-1 font-mono text-xs text-gray-700 bg-gray-50 p-3 rounded-lg break-all">{{ $activityLog->user_agent }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
