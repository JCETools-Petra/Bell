@extends('layouts.frontend')

@section('seo_title', $restaurant->name)
@section('meta_description', Str::limit(strip_tags($restaurant->description), 155))

@section('content')
<div class="page-content-wrapper">
    <div class="container my-5">
        <div class="row">
            {{-- KOLOM KIRI: GALERI GAMBAR --}}
            <div class="col-lg-7 mb-4 mb-lg-0">
                <div class="restaurant-gallery">
                    {{-- Gambar Utama --}}
                    <div class="main-image-container mb-3">
                        @if($restaurant->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $restaurant->images->first()->path) }}" alt="{{ $restaurant->name }}" class="img-fluid rounded shadow" id="main-restaurant-image">
                        @else
                            <img src="https://via.placeholder.com/800x600?text=No+Image" alt="{{ $restaurant->name }}" class="img-fluid rounded shadow" id="main-restaurant-image">
                        @endif
                    </div>

                    {{-- Gambar Thumbnail --}}
                    @if($restaurant->images->count() > 1)
                    <div class="thumbnail-images-container">
                        @foreach($restaurant->images as $image)
                        <div class="thumbnail-item">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="Thumbnail of {{ $restaurant->name }}" class="img-fluid rounded" data-large-src="{{ asset('storage/' . $image->path) }}">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- KOLOM KANAN: DESKRIPSI --}}
            <div class="col-lg-5">
                <div class="restaurant-details ps-lg-4">
                    <h1 class="display-5 mb-3">{{ $restaurant->name }}</h1>
                    <div class="restaurant-description">
                        {!! $restaurant->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mainImage = document.getElementById('main-restaurant-image');
    const thumbnails = document.querySelectorAll('.thumbnail-item img');

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Ganti gambar utama saat thumbnail diklik
            const largeSrc = this.getAttribute('data-large-src');
            mainImage.setAttribute('src', largeSrc);

            // Atur thumbnail yang aktif
            thumbnails.forEach(item => item.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Tandai thumbnail pertama sebagai aktif
    if (thumbnails.length > 0) {
        thumbnails[0].classList.add('active');
    }
});
</script>
@endpush