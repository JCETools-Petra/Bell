<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
//use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use App\Models\Affiliate;
use App\Models\Commission;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input dengan format tanggal yang benar
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'guest_name' => 'required|string|max:255',
            'guest_phone' => 'required|string|max:20',
            'guest_email' => 'required|email|max:255',
            'checkin' => 'required|date_format:d-m-Y',
            'checkout' => 'required|date_format:d-m-Y|after:checkin',
            'num_rooms' => 'required|integer|min:1',
        ]);

        $room = Room::findOrFail($request->room_id);

        // 2. Konversi format tanggal dan hitung total harga
        $checkinDate = Carbon::createFromFormat('d-m-Y', $request->checkin);
        $checkoutDate = Carbon::createFromFormat('d-m-Y', $request->checkout);
        $durationInDays = $checkoutDate->diffInDays($checkinDate);
        if ($durationInDays < 1) {
            $durationInDays = 1; // Durasi menginap minimal 1 hari
        }
        $totalPrice = $room->price * $request->num_rooms * $durationInDays;

        // 3. Simpan data booking ke database dengan status 'pending'
        $booking = Booking::create([
            'room_id' => $request->room_id,
            'guest_name' => $request->guest_name,
            'guest_phone' => $request->guest_phone,
            'guest_email' => $request->guest_email,
            'checkin_date' => $checkinDate->format('Y-m-d'),
            'checkout_date' => $checkoutDate->format('Y-m-d'),
            'num_rooms' => $request->num_rooms,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // 4. Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 5. Siapkan parameter untuk Midtrans
        $midtrans_params = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking->id . '-' . time(),
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $booking->guest_name,
                'email' => $booking->guest_email,
                'phone' => $booking->guest_phone,
            ],
            'item_details' => [[
                'id' => $booking->room_id,
                'price' => $booking->room->price,
                'quantity' => $booking->num_rooms * $durationInDays,
                'name' => 'Booking Kamar ' . $booking->room->name,
            ]],
        ];

        // 6. Dapatkan Snap Token dari Midtrans
        $snapToken = Snap::getSnapToken($midtrans_params);

        // 7. Simpan Snap Token ke database
        $booking->snap_token = $snapToken;
        $booking->save();

        // 8. Kembalikan view pembayaran dengan Snap Token (Metode BARU)
        return view('frontend.booking.payment', compact('snapToken', 'booking'));
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