<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">Welcome to the Admin Panel!</h3>
                    <p class="mb-6">
                        Dari sini, Anda dapat mengelola semua konten website Bell Hotel Merauke. Gunakan menu navigasi di atas untuk:
                    </p>
                    <ul class="list-disc list-inside mb-6 space-y-2">
                        <li><strong>Rooms:</strong> Menambah, mengubah, atau menghapus tipe kamar hotel.</li>
                        <li><strong>MICE:</strong> Mengelola ruang meeting dan event.</li>
                        <li><strong>Homepage Settings:</strong> Mengubah teks judul dan paragraf di halaman depan.</li>
                    </ul>

                    <h4 class="text-xl font-bold border-t pt-6">Website Summary</h4>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 bg-gray-100 rounded-lg shadow">
                            <h3 class="text-lg font-bold text-gray-700">Total Tipe Kamar</h3>
                            <p class="text-4xl font-extrabold text-blue-600 mt-2">{{ $roomCount }}</p>
                        </div>
                        <div class="p-6 bg-gray-100 rounded-lg shadow">
                            <h3 class="text-lg font-bold text-gray-700">Total Ruang MICE</h3>
                            <p class="text-4xl font-extrabold text-green-600 mt-2">{{ $miceCount }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>