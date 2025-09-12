<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Helpers\FonnteApi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        // 1. Set Server Key & Log
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        Log::info('--- Midtrans Callback Received ---', $request->all());

        // 2. Validate Signature Key
        $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . config('midtrans.server_key'));
        if ($hashed != $request->signature_key) {
            Log::error('Invalid Signature Key.');
            return response()->json(['message' => 'Invalid signature'], 403);
        }
        Log::info('Signature Key is valid.');

        // 3. Differentiate between Test & Real Transactions
        if (Str::startsWith($request->order_id, 'payment_notif_test_')) {
            Log::info('Test notification received from Midtrans dashboard. Responding with success.');
            return response()->json(['message' => 'Test notification processed successfully']);
        }

        $orderIdParts = explode('-', $request->order_id);
        $bookingId = $orderIdParts[1] ?? null; 

        if (!$bookingId || !is_numeric($bookingId)) {
            Log::error('Could not extract a valid numeric ID from order_id: ' . $request->order_id);
            return response()->json(['message' => 'Invalid order_id format'], 400);
        }
        
        Log::info('Extracted numeric booking ID: ' . $bookingId);
        $booking = Booking::find($bookingId);
        
        if (!$booking) {
            Log::error('Booking not found for extracted ID: ' . $bookingId);
            return response()->json(['message' => 'Booking not found'], 404);
        }

        Log::info('Found booking ID: ' . $booking->id . ' with current status: "' . $booking->status . '"');

        // 4. Update booking status on successful payment
        if (($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') && $booking->status != 'success') {
            Log::info('Transaction is successful. Updating status and sending notifications.');

            $booking->status = 'success';
            
            // ==========================================================
            //         SAVE PAYMENT METHOD INFORMATION HERE
            // ==========================================================
            $paymentType = $request->payment_type;
            $paymentMethod = Str::title(str_replace('_', ' ', $paymentType)); // Changes 'bank_transfer' to 'Bank Transfer'

            if ($paymentType == 'bank_transfer' && isset($request->va_numbers[0]['bank'])) {
                $bank = strtoupper($request->va_numbers[0]['bank']);
                $paymentMethod = "$bank Virtual Account"; // Result: "BCA Virtual Account"
            } elseif ($paymentType == 'qris') {
                 $acquirer = isset($request->acquirer) ? Str::title($request->acquirer) : 'QRIS';
                 $paymentMethod = "QRIS ($acquirer)"; // Result: "QRIS (Gopay)"
            }

            $booking->payment_method = $paymentMethod;
            // ==========================================================
            
            $booking->save();
            
            $this->sendWhatsAppNotifications($booking);
        } else {
            Log::info('Transaction status is "' . $request->transaction_status . '" or booking status is already "success". No action taken.');
        }

        Log::info('--- Midtrans Callback Processed ---');
        return response()->json(['message' => 'Callback processed successfully']);
    }

    private function sendWhatsAppNotifications($booking)
    {
        Log::info('Preparing to send WhatsApp notifications for booking ID: ' . $booking->id);
        try {
            $customerTemplate = settings('whatsapp_customer_message', 'Terima kasih! Pembayaran untuk booking ID: {booking_id} telah kami terima.');
            $adminTemplate = settings('whatsapp_admin_message', 'Pembayaran baru diterima untuk Booking ID: {booking_id}');

            // Prepare replacement data
            $replacements = [
                '{guest_name}'    => $booking->guest_name,
                '{booking_id}'    => $booking->id,
                '{guest_phone}'   => $booking->guest_phone,
                '{guest_email}'   => $booking->guest_email,
                '{checkin_date}'  => \Carbon\Carbon::parse($booking->checkin_date)->format('d M Y'),
                '{checkout_date}' => \Carbon\Carbon::parse($booking->checkout_date)->format('d M Y'),
                '{payment_method}' => $booking->payment_method ?: 'N/A', // <-- ADD THIS NEW VARIABLE
            ];

            // Create final messages
            $customerMessage = str_replace(array_keys($replacements), array_values($replacements), $customerTemplate);
            $adminMessage = str_replace(array_keys($replacements), array_values($replacements), $adminTemplate);
            
            // Send to customer
            $customerPhone = $booking->guest_phone;
            if ($customerPhone) {
                Log::info('Sending message to customer: ' . $customerPhone);
                FonnteApi::sendMessage($customerPhone, $customerMessage);
            }

            // Send to admin
            $adminPhoneNumber = env('ADMIN_WHATSAPP_NUMBER');
            if ($adminPhoneNumber) {
                Log::info('Sending message to admin: ' . $adminPhoneNumber);
                FonnteApi::sendMessage($adminPhoneNumber, $adminMessage);
            } else {
                Log::warning('ADMIN_WHATSAPP_NUMBER is not configured in .env file.');
            }
            Log::info('WhatsApp notification process finished.');
        } catch (\Exception $e) {
            Log::error('CRITICAL: Failed to send WhatsApp notification: ' . $e->getMessage());
        }
    }
}