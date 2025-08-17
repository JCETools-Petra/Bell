<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class FonnteApi
{
    private static function getClient(): Client
    {
        return new Client([
            'base_uri' => 'https://api.fonnte.com',
            'headers' => [
                'Authorization' => env('FONNTE_TOKEN'),
            ],
        ]);
    }

    public static function sendMessage($target, $message): bool
    {
        try {
            $client = self::getClient();
            $response = $client->post('/send', [
                'form_params' => [
                    'target' => $target,
                    'message' => $message,
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            return $body['status'] ?? false;
        } catch (RequestException $e) {
            // Anda bisa menambahkan logging error di sini
            // contoh: \Log::error('Fonnte API Error: ' . $e->getMessage());
            return false;
        }
    }
}