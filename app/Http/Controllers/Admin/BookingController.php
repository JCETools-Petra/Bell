<?php

namespace App\Http\Controllers\Admin; // <-- Pastikan namespace-nya 'Admin'

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller // <-- Pastikan nama class-nya benar
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('room')->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.bookings.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.bookings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        // Anda bisa membuat view 'show' nanti jika diperlukan
        // return view('admin.bookings.show', compact('booking'));
        return redirect()->route('admin.bookings.index');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        return redirect()->route('admin.bookings.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->status = $request->status;
        $booking->save();

        return back()->with('success', 'Booking status updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking deleted successfully.');
    }
}