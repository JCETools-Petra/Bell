<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Manage Recreation Areas') }}
            </h2>
            <a href="{{ route('admin.recreation_areas.create') }}" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                <i class="fas fa-plus"></i> Add New Recreation Area
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3">
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
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Slug</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Order</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Active</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-50">
                                @forelse ($recreationAreas as $area)
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-brand-dark">{{ $area->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $area->slug }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $area->order ?? 0 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $area->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $area->is_active ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('admin.recreation_areas.edit', $area) }}" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.recreation_areas.destroy', $area) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
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
                                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                            <div class="flex flex-col items-center justify-center">
                                                <i class="fas fa-swimming-pool text-4xl text-gray-200 mb-3"></i>
                                                <p>No recreation areas found.</p>
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
</x-app-layout>
