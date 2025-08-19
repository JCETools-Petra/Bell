@extends('layouts.frontend')

@section('seo_title', 'Create New Booking')

@section('content')
<div class="page-content-wrapper">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Create Booking for Customer</h4>
                    </div>
                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('affiliate.bookings.store') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="room_id" class="form-label">Pilih Kamar</label>
                                    <select name="room_id" id="room_id" class="form-select" required>
                                        <option value="">-- Pilih Kamar --</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                                {{ $room->name }} (Rp {{ number_format($room->price) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="checkin" class="form-label">Check-in</label>
                                    <input type="text" name="checkin" class="form-control datepicker" value="{{ old('checkin') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="checkout" class="form-label">Check-out</label>
                                    <input type="text" name="checkout" class="form-control datepicker" value="{{ old('checkout') }}" required>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="num_rooms" class="form-label">Jumlah Kamar</label>
                                    <input type="number" name="num_rooms" class="form-control" value="{{ old('num_rooms', 1) }}" min="1" required>
                                </div>

                                <hr class="my-3">
                                
                                <h5 class="mb-3">Data Tamu</h5>
                                <div class="col-md-12 mb-3">
                                    <label for="guest_name" class="form-label">Nama Lengkap Tamu</label>
                                    <input type="text" name="guest_name" class="form-control" value="{{ old('guest_name') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="guest_phone" class="form-label">Nomor Telepon Tamu</label>
                                    <input type="tel" name="guest_phone" class="form-control" value="{{ old('guest_phone') }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="guest_email" class="form-label">Email Tamu (Opsional)</label>
                                    <input type="email" name="guest_email" class="form-control" value="{{ old('guest_email') }}">
                                </div>
                                <div class="col-md-12 mt-3">
                                    <button type="submit" class="btn btn-primary w-100">Submit Booking</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection