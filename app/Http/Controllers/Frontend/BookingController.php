<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Affiliate;
use App\Models\Commission;
use Illuminate\Support\Facades\Session;

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

        $checkinDate = Carbon::createFromFormat('d-m-Y', $validated['checkin'])->format('Y-m-d');
        $checkoutDate = Carbon::createFromFormat('d-m-Y', $validated['checkout'])->format('Y-m-d');

        $booking = Booking::create([
            'room_id' => $validated['room_id'],
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'],
            'checkin_date' => $checkinDate,
            'checkout_date' => $checkoutDate,
            'num_rooms' => $validated['num_rooms'],
        ]);

        $room = Room::find($validated['room_id']);

        // Format nomor telepon untuk link WhatsApp
        $waFormattedPhone = $this->formatPhoneNumberForWhatsapp($booking->guest_phone);
        $waLink = "https://wa.me/{$waFormattedPhone}";

        // Format pesan WhatsApp
        $message = "🔔 *New Booking Request!* 🔔\n\n"
                 . "*Nama Tamu:* " . $booking->guest_name . "\n"
                 . "*Nomor Telepon:* " . $booking->guest_phone . "\n"
                 . "*Link WhatsApp:* " . $waLink . "\n"
                 . "*Email:* " . $booking->guest_email . "\n"
                 . "*Kamar:* " . ($room ? $room->name : 'N/A') . "\n"
                 . "*Check-in:* " . Carbon::parse($booking->checkin_date)->format('d M Y') . "\n"
                 . "*Check-out:* " . Carbon::parse($booking->checkout_date)->format('d M Y') . "\n"
                 . "*Jumlah Kamar:* " . $booking->num_rooms . "\n\n"
                 . "Mohon segera ditindaklanjuti!";

        // Kirim pesan ke nomor admin
        $adminPhoneNumber = env('ADMIN_PHONE_NUMBER');
        if ($adminPhoneNumber) {
            Http::withHeaders([
                'Authorization' => env('FONNTE_TOKEN'),
            ])->post('https://api.fonnte.com/send', [
                'target' => $adminPhoneNumber,
                'message' => $message,
            ]);
        }
        
        return back()->with('success', 'Permintaan booking Anda telah dikirim! Kami akan segera menghubungi Anda.');
    }
    
    /**
     * Memformat nomor telepon untuk tautan WhatsApp.
     */
    private function formatPhoneNumberForWhatsapp($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        if (str_starts_with($phoneNumber, '+')) {
            return substr($phoneNumber, 1);
        }
        
        if (str_starts_with($phoneNumber, '0')) {
            return '62' . substr($phoneNumber, 1);
        }
        
        return $phoneNumber;
    }
}