<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Section --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-heading font-bold text-brand-dark mb-4 flex items-center gap-2">
                        <i class="fas fa-filter text-brand-primary"></i> Filter Logs
                    </h3>
                    <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-2">User Role</label>
                            <select name="role" id="role" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all">
                                <option value="">All Roles</option>
                                <option value="affiliate" {{ request('role') == 'affiliate' ? 'selected' : '' }}>Affiliate</option>
                                <option value="frontoffice" {{ request('role') == 'frontoffice' ? 'selected' : '' }}>Front Office</option>
                            </select>
                        </div>

                        <div>
                            <label for="action" class="block text-sm font-bold text-gray-700 mb-2">Action</label>
                            <select name="action" id="action" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all">
                                <option value="">All Actions</option>
                                <option value="login" {{ request('action') == 'login' ? 'selected' : '' }}>Login</option>
                                <option value="create" {{ request('action') == 'create' ? 'selected' : '' }}>Create</option>
                                <option value="update" {{ request('action') == 'update' ? 'selected' : '' }}>Update</option>
                                <option value="delete" {{ request('action') == 'delete' ? 'selected' : '' }}>Delete</option>
                                <option value="view" {{ request('action') == 'view' ? 'selected' : '' }}>View</option>
                            </select>
                        </div>

                        <div>
                            <label for="user_id" class="block text-sm font-bold text-gray-700 mb-2">User</label>
                            <select name="user_id" id="user_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="date_from" class="block text-sm font-bold text-gray-700 mb-2">Date From</label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all">
                        </div>

                        <div>
                            <label for="date_to" class="block text-sm font-bold text-gray-700 mb-2">Date To</label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all">
                        </div>

                        <div>
                            <label for="search" class="block text-sm font-bold text-gray-700 mb-2">Search Description</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search..." class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-primary focus:ring-brand-primary transition-all">
                        </div>

                        <div class="md:col-span-3 flex justify-end gap-3 pt-2">
                            <a href="{{ route('admin.activity-logs.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">Clear</a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">Filter Logs</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Logs Table --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Time</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">IP Address</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse($logs as $log)
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($log->user)
                                                <div class="text-sm font-bold text-brand-dark">{{ $log->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $log->user->email }}</div>
                                            @else
                                                <span class="text-sm text-red-500 italic">Deleted User</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full
                                                {{ $log->user_role == 'frontoffice' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                                {{ ucfirst($log->user_role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full border
                                                @if($log->action == 'login') bg-green-50 text-green-700 border-green-200
                                                @elseif($log->action == 'create') bg-blue-50 text-blue-700 border-blue-200
                                                @elseif($log->action == 'update') bg-yellow-50 text-yellow-700 border-yellow-200
                                                @elseif($log->action == 'delete') bg-red-50 text-red-700 border-red-200
                                                @else bg-gray-50 text-gray-700 border-gray-200
                                                @endif">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $log->description }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                            {{ $log->ip_address }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if($log->changes)
                                                <button onclick="showChanges({{ $log->id }})" class="text-brand-primary hover:text-brand-dark font-bold transition-colors">View Changes</button>
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-history text-4xl text-gray-200 mb-3"></i>
                                                <p>No activity logs found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for Changes --}}
    <div id="changesModal" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-2xl shadow-2xl rounded-2xl bg-white overflow-hidden transform transition-all">
            <div class="flex justify-between items-center p-6 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-heading font-bold text-brand-dark">Changes Detail</h3>
                <button type="button" class="text-gray-400 hover:text-gray-900 transition-colors" onclick="closeChangesModal()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6 max-h-[70vh] overflow-y-auto custom-scrollbar" id="changesContent">
                <!-- Changes will be loaded here -->
            </div>
        </div>
    </div>

    <script>
        const logsData = @json($logs->map(function($log) {
            return ['id' => $log->id, 'changes' => $log->changes];
        })->keyBy('id'));

        function showChanges(logId) {
            const log = logsData[logId];
            if (!log || !log.changes) return;

            let html = '<div class="space-y-4">';
            const changes = log.changes;

            if (changes.before && changes.after) {
                html += '<div class="grid grid-cols-1 md:grid-cols-2 gap-6">';
                html += '<div class="bg-red-50 rounded-xl p-4 border border-red-100"><h4 class="font-bold text-sm mb-3 text-red-700 flex items-center gap-2"><i class="fas fa-minus-circle"></i> Before</h4><pre class="text-xs text-red-800 whitespace-pre-wrap font-mono">' + JSON.stringify(changes.before, null, 2) + '</pre></div>';
                html += '<div class="bg-green-50 rounded-xl p-4 border border-green-100"><h4 class="font-bold text-sm mb-3 text-green-700 flex items-center gap-2"><i class="fas fa-plus-circle"></i> After</h4><pre class="text-xs text-green-800 whitespace-pre-wrap font-mono">' + JSON.stringify(changes.after, null, 2) + '</pre></div>';
                html += '</div>';
            } else {
                html += '<div class="bg-gray-50 rounded-xl p-4 border border-gray-200"><pre class="text-xs text-gray-700 whitespace-pre-wrap font-mono">' + JSON.stringify(changes, null, 2) + '</pre></div>';
            }

            html += '</div>';

            document.getElementById('changesContent').innerHTML = html;
            document.getElementById('changesModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeChangesModal() {
            document.getElementById('changesModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('changesModal');
            if (event.target == modal) {
                closeChangesModal();
            }
        }
    </script>
</x-app-layout>
