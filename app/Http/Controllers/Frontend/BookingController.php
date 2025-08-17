<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

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

        // Ambil nama kamar
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
     * Menerima format lokal (08...) dan internasional (+xx...)
     *
     * @param string $phoneNumber
     * @return string
     */
    private function formatPhoneNumberForWhatsapp($phoneNumber)
    {
        // 1. Hapus semua karakter non-numerik kecuali '+' di awal
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);
        
        // 2. Jika nomor dimulai dengan '+', hapus '+' dan biarkan sisanya (sudah berformat internasional)
        if (str_starts_with($phoneNumber, '+')) {
            return substr($phoneNumber, 1);
        }
        
        // 3. Jika nomor dimulai dengan '0', ganti dengan '62' (asumsi nomor lokal Indonesia)
        if (str_starts_with($phoneNumber, '0')) {
            return '62' . substr($phoneNumber, 1);
        }
        
        // 4. Untuk semua kasus lain (sudah berformat internasional seperti '628...' atau '1...'), biarkan apa adanya
        return $phoneNumber;
    }
}