<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Notification;
use App\Models\Booking;
// (nantinya kita akan tambahkan Notifikasi WhatsApp di sini)

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // Set konfigurasi server key
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        // Buat instance notifikasi
        $notification = new Notification();

        // Ambil order_id dan status transaksi
        $status = $notification->transaction_status;
        $order_id_parts = explode('-', $notification->order_id);
        $booking_id = $order_id_parts[1]; // Ambil ID booking

        // Cari booking di database
        $booking = Booking::find($booking_id);

        // Handle status transaksi
        if ($status == 'settlement' || $status == 'capture') {
            // Update status booking menjadi 'confirmed'
            $booking->status = 'confirmed';
            $booking->save();

            // TODO: Kirim notifikasi WhatsApp ke admin dan customer
            $this->sendWhatsAppNotification($booking);

            return response()->json(['message' => 'Payment success and booking confirmed.']);
        } 

        return response()->json(['message' => 'Payment status not settlement.'], 200);
    }

    private function sendWhatsAppNotification(Booking $booking)
    {
        $adminNumber = '6281234567890'; // Ganti dengan nomor WhatsApp admin
        $customerNumber = $booking->guest_phone; // Pastikan nomor customer dalam format 62...

        // Pesan untuk Admin
        $messageForAdmin = "Notifikasi Booking Baru:\n" .
                           "Nama: " . $booking->guest_name . "\n" .
                           "Kamar: " . $booking->room->name . "\n" .
                           "Check-in: " . $booking->checkin_date . "\n" .
                           "Status: LUNAS";

        // Pesan untuk Customer
        $messageForCustomer = "Terima Kasih, " . $booking->guest_name . "!\n\n" .
                              "Pembayaran Anda untuk booking di Bell Hotel Merauke telah berhasil.\n" .
                              "ID Booking: BOOK-" . $booking->id . "\n" .
                              "Kamar: " . $booking->room->name . "\n" .
                              "Total: Rp " . number_format($booking->total_price, 0, ',', '.') . "\n\n" .
                              "Kami menantikan kedatangan Anda!";

        // Kirim ke Admin
        $this->sendFonnteMessage($adminNumber, $messageForAdmin);

        // Kirim ke Customer
        $this->sendFonnteMessage($customerNumber, $messageForCustomer);
    }

    private function sendFonnteMessage($target, $message)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.fonnte.com/send',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => ['target' => $target, 'message' => $message],
          CURLOPT_HTTPHEADER => ['Authorization: ' . env('FONNTE_API_KEY')],
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }
}