<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Edit Recreation Area') }}
            </h2>
            <a href="{{ route('admin.recreation-areas.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                <i class="fas fa-arrow-left mr-2"></i> Back
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
                <div class="p-8 text-gray-900">
                    <form action="{{ route('admin.recreation-areas.update', $recreationArea) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Recreation Area</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $recreationArea->name) }}" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm @error('name') border-red-500 @enderror" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="order" class="block text-sm font-bold text-gray-700 mb-2">Urutan Tampilan</label>
                                <input type="number" id="order" name="order" value="{{ old('order', $recreationArea->order) }}" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" min="0">
                                <p class="mt-1 text-xs text-gray-500">Semakin kecil angka, semakin atas urutannya</p>
                                @error('order')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="5" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm @error('description') border-red-500 @enderror">{{ old('description', $recreationArea->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Images</h3>
                            
                            <div class="mb-6">
                                <label for="images" class="block text-sm font-bold text-gray-700 mb-2">Tambah Gambar Baru</label>
                                <input type="file" id="images" name="images[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-brand-primary/10 file:text-brand-primary hover:file:bg-brand-primary/20 transition-all">
                                <p class="text-xs text-gray-500 mt-1">Anda dapat memilih beberapa file sekaligus.</p>
                            </div>

                            <div id="captions-container" class="mb-6 hidden bg-gray-50 p-4 rounded-xl border border-gray-100">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Caption Gambar Baru (Opsional)</label>
                                <div id="captions-list" class="space-y-3"></div>
                            </div>

                            @if ($recreationArea->images->isNotEmpty())
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach ($recreationArea->images as $image)
                                        <div class="relative group rounded-xl overflow-hidden shadow-sm border border-gray-100">
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $recreationArea->name }}" class="w-full h-32 object-cover">
                                            @if ($image->caption)
                                                <div class="absolute bottom-0 left-0 right-0 bg-black/50 p-1">
                                                    <p class="text-xs text-white text-center truncate">{{ $image->caption }}</p>
                                                </div>
                                            @endif
                                            <button type="submit" form="delete-image-{{ $image->id }}"
                                                class="absolute top-2 right-2 p-2 bg-red-500 text-white rounded-lg opacity-0 group-hover:opacity-100 transition-all shadow-lg hover:bg-red-600"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus gambar ini?')"
                                                aria-label="Hapus gambar">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="border-t border-gray-100 pt-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $recreationArea->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-brand-primary shadow-sm focus:ring-brand-primary">
                                <span class="ml-2 text-sm font-bold text-gray-700">Aktif (tampilkan di website)</span>
                            </div>
                        </div>

                        <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.recreation-areas.index') }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Perbarui
                            </button>
                        </div>
                    </form>

                    {{-- Form DELETE gambar diletakkan di luar form utama (hidden) --}}
                    @if ($recreationArea->images->isNotEmpty())
                        @foreach ($recreationArea->images as $image)
                            <form id="delete-image-{{ $image->id }}"
                                  action="{{ route('admin.recreation-areas.image.destroy', ['image' => $image->id]) }}"
                                  method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const files = e.target.files;
            const container = document.getElementById('captions-container');
            const list = document.getElementById('captions-list');

            if (files.length > 0) {
                container.classList.remove('hidden');
                list.innerHTML = '';

                for (let i = 0; i < files.length; i++) {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <label class="block text-xs font-medium text-gray-600 mb-1">${files[i].name}</label>
                        <input type="text" name="captions[]" placeholder="Caption untuk gambar ini" class="w-full rounded-xl border-gray-300 shadow-sm text-sm focus:border-brand-primary focus:ring-brand-primary">
                    `;
                    list.appendChild(div);
                }
            } else {
                container.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
