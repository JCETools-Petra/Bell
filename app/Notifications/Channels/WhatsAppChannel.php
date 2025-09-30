<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Notification;
use App\Helpers\FonnteApi; // Memanggil helper Fonnte yang sudah ada

class WhatsAppChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Panggil metode toWhatsApp dari notifikasi untuk mendapatkan pesan
        $message = $notification->toWhatsApp($notifiable);

        // Pastikan pengguna memiliki nomor telepon yang bisa dihubungi
        if (! $notifiable->routeNotificationFor('whatsapp')) {
            return;
        }
        
        $recipientNumber = $notifiable->routeNotificationFor('whatsapp');

        // Kirim pesan menggunakan Fonnte API
        FonnteApi::sendMessage($recipientNumber, $message);
    }
}