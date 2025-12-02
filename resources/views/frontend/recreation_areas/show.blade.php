@extends('layouts.frontend')

@section('seo_title', $recreationArea->name . ' - Sora Hotel Merauke')
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($recreationArea->description), 160))

@section('content')
    {{-- 1. HEADER IMAGE --}}
    <div class="bg-gray-900 pt-24 pb-12 relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-30">
            @if($recreationArea->images->isNotEmpty())
                <img src="{{ asset('storage/' . $recreationArea->images->first()->image_path) }}" class="w-full h-full object-cover blur-sm">
            @endif
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent z-0"></div>

        <div class="container mx-auto px-4 relative z-10">
            <nav class="flex text-sm text-gray-400 mb-4">
                <a href="{{ route('home') }}" class="hover:text-brand-secondary transition-colors">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('recreation-areas.index') }}" class="hover:text-brand-secondary transition-colors">Recreation Areas</a>
                <span class="mx-2">/</span>
                <span class="text-white">{{ $recreationArea->name }}</span>
            </nav>
            <h1 class="text-3xl md:text-5xl font-heading font-bold text-white mb-2">{{ $recreationArea->name }}</h1>
            <p class="text-brand-secondary text-lg font-medium flex items-center gap-2">
                <i class="fas fa-map-marker-alt"></i> Sora Hotel Merauke
            </p>
        </div>
    </div>

    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">

                {{-- KOLOM KIRI: GALERI & INFO --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Gallery --}}
                    <div class="bg-white rounded-2xl shadow-sm p-2 border border-gray-100 overflow-hidden">
                        @if($recreationArea->images->isNotEmpty())
                            <div class="relative h-[400px] md:h-[500px] rounded-xl overflow-hidden mb-2 group">
                                <img id="mainImage" src="{{ asset('storage/' . $recreationArea->images->first()->image_path) }}"
                                     alt="{{ $recreationArea->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            </div>
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($recreationArea->images as $image)
                                    <button onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')"
                                            class="relative h-20 md:h-24 rounded-lg overflow-hidden cursor-pointer opacity-70 hover:opacity-100 transition-opacity focus:outline-none focus:ring-2 focus:ring-brand-secondary">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover">
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <div class="h-[400px] bg-gray-200 rounded-xl flex items-center justify-center text-gray-400">
                                <div class="text-center">
                                    <i class="fas fa-image text-4xl mb-2 opacity-50"></i>
                                    <p>No Images Available</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Description --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-gray-100 pb-4 flex items-center gap-3">
                            <i class="fas fa-info-circle text-brand-secondary"></i> About This Area
                        </h3>
                        <div class="prose max-w-none text-gray-600 leading-relaxed space-y-4">
                            {!! nl2br(e($recreationArea->description)) !!}
                        </div>
                    </div>

                    {{-- Image Captions (if available) --}}
                    @if($recreationArea->images->where('caption', '!=', '')->isNotEmpty())
                    <div class="bg-white rounded-2xl shadow-sm p-6 md:p-8 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <i class="fas fa-images text-brand-secondary"></i> Gallery Highlights
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($recreationArea->images->where('caption', '!=', '') as $image)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 text-brand-secondary flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-check-circle text-sm"></i>
                                    </div>
                                    <span class="text-gray-600 text-sm font-medium mt-1.5">{{ $image->caption }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- KOLOM KANAN: INFO CARD (Sticky) --}}
                <div class="lg:col-span-1">
                    <div class="sticky top-24 space-y-6">

                        {{-- Info Card --}}
                        <div class="bg-white rounded-2xl shadow-lg border-t-4 border-brand-secondary overflow-hidden">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Facility Information</h3>
                                <p class="text-sm text-gray-500 mb-6">Need more details about this recreation area?</p>

                                <div class="space-y-4">
                                    <a href="{{ route('contact.index') }}"
                                       class="w-full bg-brand-secondary hover:bg-brand-secondary/90 text-white font-bold py-3.5 px-6 rounded-lg transition-all duration-300 shadow-lg transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                        <i class="fas fa-envelope"></i>
                                        <span>Contact Us</span>
                                    </a>

                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', settings('contact_phone') ?? '6281234567890') }}"
                                       target="_blank"
                                       class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 px-6 rounded-lg transition-all duration-300 shadow-lg transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                        <i class="fab fa-whatsapp text-lg"></i>
                                        <span>Chat on WhatsApp</span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        {{-- Operating Hours (Optional) --}}
                        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100">
                            <h4 class="font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-clock text-brand-secondary"></i> Operating Hours
                            </h4>
                            <div class="text-sm text-gray-600 space-y-2">
                                <div class="flex justify-between">
                                    <span>Monday - Friday</span>
                                    <span class="font-bold">06:00 - 22:00</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Weekend & Holidays</span>
                                    <span class="font-bold">06:00 - 23:00</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mt-3 italic">*Operating hours may vary. Please contact us for confirmation.</p>
                        </div>

                        {{-- Back to List --}}
                        <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-100 text-center">
                            <a href="{{ route('recreation-areas.index') }}" class="text-brand-secondary font-bold hover:text-brand-secondary/80 transition-colors flex items-center justify-center gap-2">
                                <i class="fas fa-arrow-left"></i> Back to All Recreation Areas
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Image Gallery Switcher
        function changeImage(src) {
            const mainImage = document.getElementById('mainImage');
            mainImage.style.opacity = '0';
            setTimeout(() => {
                mainImage.src = src;
                mainImage.style.opacity = '1';
            }, 200);
        }
    </script>
    @endpush
@endsection
