<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-heading font-bold text-2xl text-brand-dark leading-tight">
                {{ __('Contact Page Settings') }}
            </h2>
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
                    <form action="{{ route('admin.contact.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            {{-- Address --}}
                            <div>
                                <label for="contact_address" class="block text-sm font-bold text-gray-700 mb-2">Alamat Kantor</label>
                                <textarea name="contact_address" id="contact_address" rows="3" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                            </div>

                            {{-- Phone and Email --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="contact_phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                                    <input type="text" name="contact_phone" id="contact_phone" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['contact_phone'] ?? '' }}">
                                </div>
                                <div>
                                    <label for="contact_email" class="block text-sm font-bold text-gray-700 mb-2">Alamat Email</label>
                                    <input type="email" name="contact_email" id="contact_email" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['contact_email'] ?? '' }}">
                                </div>
                            </div>

                            {{-- Google Maps Embed --}}
                            <div>
                                <label for="contact_maps_embed" class="block text-sm font-bold text-gray-700 mb-2">Kode Semat (Embed) Google Maps</label>
                                <textarea name="contact_maps_embed" id="contact_maps_embed" rows="5" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ $settings['contact_maps_embed'] ?? '' }}</textarea>
                                <p class="text-xs text-gray-500 mt-1">Buka Google Maps, cari lokasi, klik "Share" > "Embed a map", lalu salin dan tempel kode HTML di sini.</p>
                            </div>

                            <div class="border-t border-gray-100 pt-6">
                                {{-- SEO Settings --}}
                                <h4 class="text-lg font-bold text-gray-900 mb-4">SEO Settings</h4>
                                <div class="space-y-6">
                                    <div>
                                        <label for="contact_seo_title" class="block text-sm font-bold text-gray-700 mb-2">SEO Title</label>
                                        <input type="text" name="contact_seo_title" id="contact_seo_title" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm" value="{{ $settings['contact_seo_title'] ?? '' }}">
                                    </div>
                                    <div>
                                        <label for="contact_seo_description" class="block text-sm font-bold text-gray-700 mb-2">SEO Meta Description</label>
                                        <textarea name="contact_seo_description" id="contact_seo_description" rows="2" class="w-full rounded-xl border-gray-300 focus:border-brand-primary focus:ring-brand-primary shadow-sm">{{ $settings['contact_seo_description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-brand-primary text-white font-bold rounded-xl shadow-lg shadow-brand-primary/30 hover:bg-brand-dark transition-all transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i> Save Contact Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>