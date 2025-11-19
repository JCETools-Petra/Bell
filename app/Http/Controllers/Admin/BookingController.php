<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Commission;
use Illuminate\Support\Facades\Gate;
use App\Models\Affiliate;
use App\Services\CommissionService;

class BookingController extends Controller
{
    protected $commissionService;

    public function __construct(CommissionService $commissionService)
    {
        $this->commissionService = $commissionService;
    }
    public function index()
    {
        $bookings = Booking::with(['room', 'affiliate.user'])->latest()->paginate(15); // Muat juga data affiliate
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        return redirect()->route('admin.bookings.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        return redirect()->route('admin.bookings.index');
    }

    public function edit(Booking $booking)
    {
        return redirect()->route('admin.bookings.index');
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $newStatus = $request->status;
        $booking->status = $newStatus;
        $booking->save();

        // Cek jika status diubah menjadi "confirmed" DAN booking ini memiliki affiliate
        if ($newStatus === 'confirmed' && $booking->affiliate_id) {
            $this->commissionService->createForBooking($booking);
        }
        // Jika status diubah menjadi "cancelled", hapus komisi yang mungkin sudah ada
        elseif ($newStatus === 'cancelled') {
            Commission::where('booking_id', $booking->id)->delete();
        }

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return back()->with('success', 'Booking deleted successfully.');
    }
    
    public function confirmPayAtHotel(Booking $booking)
    {
        // 1. Pastikan booking ini memang 'bayar di hotel' dan statusnya benar
        if ($booking->payment_method !== 'pay_at_hotel' || $booking->status !== 'awaiting_arrival') {
            return back()->with('error', 'This booking is not a valid "Pay at Hotel" booking awaiting confirmation.');
        }

        // 2. Buat komisi untuk afiliasi
        $this->commissionService->createForBooking($booking);

        // 3. Ubah status booking menjadi 'confirmed'
        $booking->update(['status' => 'confirmed']);

        return back()->with('success', "Booking #{$booking->id} has been confirmed and commission has been generated.");
    }

    // createCommissionForBooking removed as it is replaced by CommissionService
}