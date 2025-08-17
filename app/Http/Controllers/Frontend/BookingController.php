<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
            'checkin' => 'required|string',
            'checkout' => 'required|string',
            'num_rooms' => 'required|integer|min:1',
        ]);

        Booking::create([
            'room_id' => $validated['room_id'],
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'checkin_date' => Carbon::createFromFormat('d-m-Y', $validated['checkin'])->format('Y-m-d'),
            'checkout_date' => Carbon::createFromFormat('d-m-Y', $validated['checkout'])->format('Y-m-d'),
            'num_rooms' => $validated['num_rooms'],
        ]);

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Your booking request has been sent! We will contact you shortly.');
    }
}