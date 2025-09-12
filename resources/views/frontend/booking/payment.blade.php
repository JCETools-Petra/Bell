@extends('layouts.frontend')

@section('content')
<div class="container py-5" style="min-height: 60vh;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <h2 class="mb-3">Selesaikan Pembayaran Anda</h2>
                    <p class="text-muted">Satu langkah lagi untuk mengonfirmasi pesanan Anda. Silakan klik tombol di bawah untuk melanjutkan ke pembayaran yang aman melalui Midtrans.</p>
                    <hr class="my-4">
                    
                    <h5>Detail Booking ID: #{{ $booking->id }}</h5>
                    <p>Total Tagihan: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>

                    <button id="pay-button" class="btn btn-primary btn-lg mt-3">Bayar Sekarang</button>

                    <p class="mt-4 text-sm text-muted">Anda akan diarahkan ke halaman konfirmasi setelah pembayaran berhasil.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================== --}}
{{--         PERBAIKAN ADA DI BLOK SCRIPT DI BAWAH INI          --}}
{{-- ========================================================== --}}

{{-- Muat library Snap.js dari Midtrans secara dinamis --}}
<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                window.location.href = '{{ route("booking.success", $booking->access_token) }}';
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda!");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            },
            onClose: function(){
                alert('Anda menutup jendela pembayaran sebelum selesai.');
            }
        });
    });
</script>
@endsection