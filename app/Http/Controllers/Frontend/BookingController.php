<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Str;
use App\Helpers\FonnteApi; // <-- Pastikan ini di-import
use Illuminate\Support\Facades\Log; // <-- Import Log untuk debugging

class BookingController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Settings update hit', [
        'booking_method_input' => $request->input('booking_method'),
    ]);
        // 1. Validasi (Tetap sama)
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

        // 2. Kalkulasi harga (PERBAIKAN LOGIKA)
        $checkinDate = Carbon::createFromFormat('d-m-Y', $request->checkin);
        $checkoutDate = Carbon::createFromFormat('d-m-Y', $request->checkout);
        // Menggunakan metode diff()->days untuk hasil yang selalu positif dan akurat
        $durationInDays = $checkinDate->diff($checkoutDate)->days;
        if ($durationInDays < 1) {
            $durationInDays = 1; // Pastikan minimal menginap 1 malam
        }
        $totalPrice = $room->price * $request->num_rooms * $durationInDays;

        // 3. Simpan data booking (Tetap sama)
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
            'access_token' => Str::uuid()->toString(),
        ]);

        // Logika Percabangan Metode Booking
        if (settings('booking_method', 'direct') == 'direct') {
            
            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // ==========================================================
            //         PERBAIKAN DAN PENYEDERHANAAN ITEM DETAILS
            // ==========================================================
            $midtrans_params = [
                'transaction_details' => [
                    'order_id' => 'BOOK-' . $booking->id . '-' . time(),
                    'gross_amount' => $totalPrice, // Total harga keseluruhan
                ],
                'customer_details' => [
                    'first_name' => $booking->guest_name,
                    'email' => $booking->guest_email,
                    'phone' => $booking->guest_phone,
                ],
                // Kita sederhanakan item_details menjadi satu paket booking.
                // Ini lebih aman dan menghindari error kalkulasi.
                'item_details' => [[
                    'id' => $booking->id,
                    'price' => $totalPrice, // Harga adalah total harga itu sendiri
                    'quantity' => 1,         // Kuantitas selalu 1 paket
                    'name' => "Booking {$booking->room->name} ({$booking->num_rooms} kamar, {$durationInDays} malam)",
                ]],
                'callbacks' => [
                    'finish' => route('booking.success', $booking->access_token)
                ]
            ];
            // ==========================================================

            $snapToken = Snap::getSnapToken($midtrans_params);
            $booking->snap_token = $snapToken;
            $booking->save();

            return view('frontend.booking.payment', compact('snapToken', 'booking'));

        } else {
            // Alur Manual Booking (WhatsApp)
            $this->sendAdminBookingNotification($booking);
            return redirect()->back()->with('success', 'Permintaan booking Anda telah berhasil dikirim! Admin kami akan segera menghubungi Anda melalui WhatsApp.');
        }
    }
    
    /**
     * Menampilkan halaman sukses setelah pembayaran.
     */
    public function success(string $token)
    {
        $booking = Booking::where('access_token', $token)->firstOrFail();
        return view('frontend.booking_success', compact('booking'));
    }
    
    /**
     * Mengirim notifikasi booking baru ke admin via WhatsApp untuk metode manual.
     */
    private function sendAdminBookingNotification(Booking $booking)
    {
        try {
            $adminPhoneNumber = env('ADMIN_WHATSAPP_NUMBER');
            if ($adminPhoneNumber) {
                $checkinDate = Carbon::parse($booking->checkin_date)->format('d M Y');
                $checkoutDate = Carbon::parse($booking->checkout_date)->format('d M Y');

                $adminMessage = "🔔 *Permintaan Booking Baru!*\n\n" .
                                "*Booking ID:* {$booking->id}\n" .
                                "*Nama Tamu:* {$booking->guest_name}\n" .
                                "*Telepon:* {$booking->guest_phone}\n" .
                                "*Email:* {$booking->guest_email}\n" .
                                "*Kamar:* {$booking->room->name}\n" .
                                "*Jumlah Kamar:* {$booking->num_rooms}\n" .
                                "*Check-in:* {$checkinDate}\n" .
                                "*Check-out:* {$checkoutDate}\n" .
                                "*Total Harga:* Rp " . number_format($booking->total_price, 0, ',', '.');
                
                FonnteApi::sendMessage($adminPhoneNumber, $adminMessage);
                Log::info('Admin booking notification sent for booking ID: ' . $booking->id);
            } else {
                Log::warning('ADMIN_WHATSAPP_NUMBER is not configured. Could not send booking notification.');
            }
        } catch (\Exception $e) {
            Log::error('Failed to send admin booking notification: ' . $e->getMessage());
        }
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