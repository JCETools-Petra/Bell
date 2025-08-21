@extends('layouts.frontend')

@section('content')
<div class="container text-center" style="padding: 8rem 0;">
    <h2>Selesaikan Pembayaran Anda</h2>
    <p>Total Tagihan: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>
    <p>Terima kasih telah melakukan pemesanan. Silakan klik tombol di bawah untuk melanjutkan ke pembayaran.</p>
    
    <button id="pay-button" class="btn btn-custom">Bayar Sekarang</button>
</div>

{{-- Script Midtrans --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    // Ambil tombol bayar
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        // Panggil snap.pay() dengan Snap Token yang sudah didapat dari controller
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){
                /* Anda bisa menampilkan pesan sukses di sini */
                alert("Pembayaran berhasil!"); 
                window.location.href = '{{ route("home") }}'; // Redirect ke halaman home
            },
            onPending: function(result){
                /* Anda bisa menampilkan pesan pending di sini */
                alert("Menunggu pembayaran Anda!");
            },
            onError: function(result){
                /* Anda bisa menampilkan pesan error di sini */
                alert("Pembayaran gagal!");
            },
            onClose: function(){
                /* Anda bisa menampilkan pesan jika pop-up ditutup sebelum selesai */
                alert('Anda menutup pop-up tanpa menyelesaikan pembayaran');
            }
        });
    });
</script>
@endsection