<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Commission;
use Illuminate\Support\Facades\Gate;
use App\Models\Affiliate;
use App\Models\ActivityLog;

class BookingController extends Controller
{
    public function index()
    {
        // Check authorization
        if (! Gate::allows('manage-bookings')) {
            abort(403, 'Unauthorized access to bookings.');
        }

        $bookings = Booking::with(['room', 'affiliate.user'])->latest()->paginate(15);
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

        $oldStatus = $booking->status;
        $newStatus = $request->status;

        $booking->status = $newStatus;
        $booking->save();

        // Log aktivitas perubahan status booking
        ActivityLog::createLog(
            action: 'booking_status_changed',
            description: "Changed booking #{$booking->id} status from '{$oldStatus}' to '{$newStatus}'",
            modelType: 'Booking',
            modelId: $booking->id,
            oldValues: ['status' => $oldStatus],
            newValues: ['status' => $newStatus]
        );

        // Cek jika status diubah menjadi "confirmed" DAN booking ini memiliki affiliate
        if ($newStatus === 'confirmed' && $booking->affiliate_id) {
            // Cek untuk memastikan komisi belum pernah dibuat untuk booking ini
            $existingCommission = Commission::where('booking_id', $booking->id)->first();

            if (!$existingCommission) {
                $affiliate = $booking->affiliate;
                $room = $booking->room;

                if ($affiliate && $room) {
                    $commissionAmount = ($room->price * $booking->num_rooms) * ($affiliate->commission_rate / 100);

                    Commission::create([
                        'affiliate_id' => $affiliate->id,
                        'booking_id' => $booking->id,
                        'amount' => $commissionAmount,
                        'status' => 'unpaid',
                    ]);
                }
            }
        }
        // Jika status diubah menjadi "cancelled", hapus komisi yang mungkin sudah ada
        elseif ($newStatus === 'cancelled') {
            $deletedCount = Commission::where('booking_id', $booking->id)->count();
            Commission::where('booking_id', $booking->id)->delete();

            if ($deletedCount > 0) {
                ActivityLog::createLog(
                    action: 'booking_cancelled_commission_deleted',
                    description: "Cancelled booking #{$booking->id} - Deleted {$deletedCount} commission(s)",
                    modelType: 'Booking',
                    modelId: $booking->id
                );
            }
        }

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $bookingId = $booking->id;
        $guestName = $booking->guest_name;
        $bookingData = [
            'id' => $booking->id,
            'guest_name' => $booking->guest_name,
            'guest_email' => $booking->guest_email,
            'status' => $booking->status,
            'total_price' => $booking->total_price,
        ];

        $booking->delete();

        // Log aktivitas penghapusan booking
        ActivityLog::createLog(
            action: 'booking_deleted',
            description: "Deleted booking #{$bookingId} for guest '{$guestName}'",
            modelType: 'Booking',
            modelId: $bookingId,
            oldValues: $bookingData
        );

        return back()->with('success', 'Booking deleted successfully.');
    }
    
    public function confirmPayAtHotel(Booking $booking)
    {
        // 1. Pastikan booking ini memang 'bayar di hotel' dan statusnya benar
        if ($booking->payment_method !== 'pay_at_hotel' || $booking->status !== 'awaiting_arrival') {
            return back()->with('error', 'This booking is not a valid "Pay at Hotel" booking awaiting confirmation.');
        }

        // 2. Buat komisi untuk afiliasi
        $this->createCommissionForBooking($booking);

        // 3. Ubah status booking menjadi 'confirmed'
        $booking->update(['status' => 'confirmed']);

        return back()->with('success', "Booking #{$booking->id} has been confirmed and commission has been generated.");
    }

    private function createCommissionForBooking(Booking $booking)
    {
        // Pastikan booking ini memiliki afiliasi
        if (!$booking->affiliate_id) {
            return;
        }

        $affiliate = Affiliate::find($booking->affiliate_id);
        if (!$affiliate || $affiliate->commission_rate <= 0) {
            return;
        }

        // Hitung jumlah komisi
        $commissionAmount = $booking->total_price * ($affiliate->commission_rate / 100);

        // Buat catatan komisi
        Commission::create([
            'affiliate_id' => $affiliate->id,
            'booking_id' => $booking->id,
            'commission_amount' => $commissionAmount,
            'rate' => $affiliate->commission_rate,
            'status' => 'unpaid', // Komisi siap untuk dibayarkan nanti
            'notes' => 'Commission from Booking ID #' . $booking->id,
        ]);
    }
}