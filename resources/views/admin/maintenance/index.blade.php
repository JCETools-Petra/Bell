<x-app-layout>
    <x-slot name="header">
        <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
            Pengaturan Maintenance Mode
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 text-green-700 border border-green-200 rounded-xl flex items-center gap-3 shadow-sm">
                    <i class="fas fa-check-circle text-xl"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100">
                <div class="p-8 bg-white border-b border-gray-100">
                    <form action="{{ route('admin.maintenance.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full bg-brand-light flex items-center justify-center text-brand-primary text-xl">
                                    <i class="fas fa-tools"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-heading font-bold text-brand-dark">Status Website</h3>
                                    <p class="text-sm text-gray-500">Kontrol akses publik ke website Anda.</p>
                                </div>
                            </div>
                            
                            <p class="text-gray-600 mb-6 bg-blue-50 p-4 rounded-xl border border-blue-100">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                Gunakan tombol di bawah ini untuk mengaktifkan atau menonaktifkan mode perbaikan untuk seluruh website (kecuali halaman admin).
                            </p>
                            
                            <div class="flex items-center justify-between p-6 bg-gray-50 rounded-2xl border border-gray-200">
                                <div>
                                    <label class="font-bold text-gray-700 block mb-1" for="maintenanceSwitch">Mode Maintenance</label>
                                    <div class="text-sm">
                                        @if($isDown)
                                            <span class="text-red-600 font-bold flex items-center gap-2"><i class="fas fa-circle text-[10px]"></i> Maintenance Mode AKTIF</span>
                                        @else
                                            <span class="text-green-600 font-bold flex items-center gap-2"><i class="fas fa-circle text-[10px]"></i> Website LIVE</span>
                                        @endif
                                    </div>
                                </div>
                                
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="maintenanceSwitch" name="maintenance_mode" class="sr-only peer" {{ $isDown ? 'checked' : '' }}>
                                    <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-brand-primary"></div>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-8 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>