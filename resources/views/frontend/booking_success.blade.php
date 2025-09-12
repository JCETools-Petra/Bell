@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <h1 class="text-success mb-3">✅<br>Pembayaran Berhasil!</h1>
                    <p class="lead">Terima kasih, {{ $booking->guest_name }}. Pesanan Anda telah kami konfirmasi.</p>
                    <hr class="my-4">
                    
                    <h5 class="text-start mb-3">Detail Pesanan</h5>
                    <div class="text-start">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 40%;">ID Booking</th>
                                    <td>{{ $booking->id }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Nama Tamu</th>
                                    <td>{{ $booking->guest_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Telepon</th>
                                    <td>{{ $booking->guest_phone }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $booking->guest_email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tipe Kamar</th>
                                    <td>{{ $booking->room->name }}</td>
                                </tr>
                                 <tr>
                                    <th scope="row">Jumlah Kamar</th>
                                    <td>{{ $booking->num_rooms }} kamar</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Check-in</th>
                                    <td>{{ \Carbon\Carbon::parse($booking->checkin_date)->format('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Tanggal Check-out</th>
                                    <td>{{ \Carbon\Carbon::parse($booking->checkout_date)->format('l, d F Y') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Pembayaran</th>
                                    <td><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></td>
                                </tr>
                                @if($booking->payment_method)
                                <tr>
                                    <th scope="row">Metode Pembayaran</th>
                                    <td>{{ $booking->payment_method }}</td>
                                </tr>
                                @endif
                                 <tr>
                                    <th scope="row">Status</th>
                                    <td><span class="badge bg-success">Lunas</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="mt-4">Kami telah mengirimkan detail pesanan ini ke email Anda. Terima kasih telah memilih Bell Hotel Merauke.</p>

                    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection