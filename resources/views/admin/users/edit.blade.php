<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Edit User: ') . $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Name</label>
                            <input type="text" name="name" id="name" value="{{ $user->name }}" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" required>
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-bold text-gray-700 mb-2">Role</label>
                            <select name="role" id="role" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" required>
                                <option value="admin" @selected($user->role == 'admin')>Admin</option>
                                <option value="accounting" @selected($user->role == 'accounting')>Accounting</option>
                                <option value="affiliate" @selected($user->role == 'affiliate')>Affiliate</option>
                                <option value="frontoffice" {{ $user->role == 'frontoffice' ? 'selected' : '' }}>Front Office</option>
                                <option value="user" @selected($user->role == 'user')>User</option>
                            </select>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>