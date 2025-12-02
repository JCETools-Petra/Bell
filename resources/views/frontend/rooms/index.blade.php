@extends('layouts.frontend')

@section('seo_title', 'Accommodation - Sora Hotel Merauke')

@section('content')
    {{-- 1. PAGE HEADER --}}
    <div class="relative bg-brand-dark py-24 sm:py-32 overflow-hidden">
        {{-- Background Pattern/Image --}}
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=1920&auto=format&fit=crop" 
                 alt="Luxury Room Background" 
                 class="w-full h-full object-cover opacity-40">
            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/60 to-brand-primary/30 mix-blend-multiply"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-brand-secondary font-bold uppercase tracking-widest text-sm mb-2 block animate-fade-in-up">Stay With Us</span>
            <h1 class="text-4xl md:text-6xl font-heading font-bold text-white mb-6 tracking-tight animate-fade-in-up delay-100">
                Luxurious <span class="text-brand-secondary">Accommodation</span>
            </h1>
            <p class="text-blue-100 text-lg max-w-2xl mx-auto font-light leading-relaxed animate-fade-in-up delay-200">
                Temukan kenyamanan istimewa dalam setiap detail kamar kami. Dirancang dengan nuansa laut yang menenangkan untuk pengalaman menginap terbaik.
            </p>
        </div>
    </div>

    {{-- 2. ROOM LIST SECTION --}}
    <div class="bg-brand-light py-16 sm:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Room Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($rooms as $room)
                    <div class="group bg-white rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-white/50 overflow-hidden flex flex-col h-full transform hover:-translate-y-1">
                        
                        {{-- Image Wrapper --}}
                        <div class="relative h-72 overflow-hidden">
                            {{-- Logika Gambar Pintar --}}
                            <img src="{{ $room->image ? asset('storage/' . $room->image) : ($room->images->first() ? asset('storage/' . $room->images->first()->path) : 'https://placehold.co/600x400?text=No+Image') }}" 
                                 alt="{{ $room->name }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-brand-dark/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                            {{-- Badge Tipe --}}
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full shadow-sm">
                                <span class="text-xs font-bold uppercase tracking-wider text-brand-primary">
                                    {{ $room->type ?? 'Room' }}
                                </span>
                            </div>
                        </div>

                        {{-- Card Content --}}
                        <div class="p-8 flex flex-col flex-grow">
                            <div class="mb-4">
                                <h3 class="text-2xl font-heading font-bold text-brand-dark group-hover:text-brand-secondary transition-colors mb-2">
                                    {{ $room->name }}
                                </h3>
                                <div class="w-12 h-1 bg-brand-secondary/30 rounded-full"></div>
                            </div>

                            <p class="text-gray-500 text-sm mb-6 line-clamp-3 flex-grow leading-relaxed">
                                {{ $room->description }}
                            </p>

                            {{-- Price & Action --}}
                            <div class="pt-6 border-t border-gray-100 flex items-center justify-between mt-auto">
                                <div>
                                    <span class="text-xs text-gray-400 uppercase font-semibold tracking-wide">Start From</span>
                                    <div class="text-xl font-bold text-brand-primary">
                                        Rp {{ number_format($room->price, 0, ',', '.') }}
                                        <span class="text-sm font-normal text-gray-400">/night</span>
                                    </div>
                                </div>
                                <a href="{{ route('rooms.show', $room->slug ?? $room->id) }}" 
                                   class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-brand-light text-brand-primary hover:bg-brand-primary hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-brand-light mb-6">
                            <i class="fas fa-bed text-3xl text-brand-secondary/50"></i>
                        </div>
                        <h3 class="text-xl font-bold text-brand-dark">Belum ada kamar tersedia</h3>
                        <p class="text-gray-500 mt-2">Silakan periksa kembali nanti untuk penawaran terbaru.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-16 flex justify-center">
                {{ $rooms->links() }} 
            </div>
        </div>
    </div>

    <style>
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fade-in-up 0.8s ease-out forwards; opacity: 0; }
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
    </style>
@endsection

