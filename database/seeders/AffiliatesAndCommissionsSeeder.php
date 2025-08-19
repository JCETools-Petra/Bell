<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AffiliatesAndCommissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Data Afiliasi
        DB::table('affiliates')->insert([
            [
                'id' => 1,
                'user_id' => 3,
                'referral_code' => 'FS5PSDCH',
                'commission_rate' => 10.00,
                'status' => 'active',
                'created_at' => '2025-08-17 23:56:14',
                'updated_at' => '2025-08-17 23:59:50',
            ],
        ]);

        // Data Kunjungan Afiliasi
        DB::table('affiliate_visits')->insert([
            [
                'id' => 1,
                'affiliate_id' => 1,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)...',
                'created_at' => '2025-08-18 00:04:29',
                'updated_at' => '2025-08-18 00:04:29',
            ],
        ]);

        // Data Komisi
        DB::table('commissions')->insert([
            [
                'id' => 5,
                'affiliate_id' => 1,
                'booking_id' => 11,
                'amount' => 600000.00,
                'status' => 'paid',
                'created_at' => '2025-08-18 02:02:19',
                'updated_at' => '2025-08-18 05:49:28',
            ],
            [
                'id' => 6,
                'affiliate_id' => 1,
                'booking_id' => 12,
                'amount' => 1200000.00,
                'status' => 'unpaid',
                'created_at' => '2025-08-18 19:37:05',
                'updated_at' => '2025-08-18 19:37:05',
            ],
        ]);
    }
}