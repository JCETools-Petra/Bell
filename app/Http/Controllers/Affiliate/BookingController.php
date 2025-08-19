<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;
// use App\Models\Commission; // This is no longer needed here
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    /**
     * Menampilkan form untuk membuat booking baru.
     */
    public function create()
    {
        $rooms = Room::where('is_available', true)->get();
        return view('frontend.affiliate.bookings.create', compact('rooms'));
    }

    /**
     * Menyimpan booking yang dibuat oleh affiliate.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'nullable|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'checkin' => 'required|date_format:d-m-Y',
            'checkout' => 'required|date_format:d-m-Y|after:checkin',
            'num_rooms' => 'required|integer|min:1',
        ]);

        $affiliate = Auth::user()->affiliate;

        // Buat booking baru dengan data affiliate, status defaultnya adalah 'pending'
        $booking = Booking::create([
            'affiliate_id' => $affiliate->id,
            'booking_source' => 'Affiliate',
            'room_id' => $validated['room_id'],
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'checkin_date' => Carbon::createFromFormat('d-m-Y', $validated['checkin'])->format('Y-m-d'),
            'checkout_date' => Carbon::createFromFormat('d-m-Y', $validated['checkout'])->format('Y-m-d'),
            'num_rooms' => $validated['num_rooms'],
        ]);

        // Logika untuk menghitung dan mencatat komisi sudah DIHAPUS dari sini.

        // Ubah pesan sukses agar lebih sesuai
        return redirect()->route('affiliate.dashboard')->with('success', 'Booking berhasil dibuat dan akan segera diproses oleh admin.');
    }
}