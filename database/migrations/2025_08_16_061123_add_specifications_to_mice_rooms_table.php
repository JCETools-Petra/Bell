<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mice_rooms', function (Blueprint $table) {
            // Cek satu per satu sebelum menambahkan agar tidak error jika dijalankan ulang sebagian
            if (!Schema::hasColumn('mice_rooms', 'dimension')) {
                $table->string('dimension')->nullable()->after('slug');
            }
            if (!Schema::hasColumn('mice_rooms', 'size_sqm')) {
                $table->string('size_sqm')->nullable()->after('dimension');
            }
            if (!Schema::hasColumn('mice_rooms', 'capacity_classroom')) {
                $table->integer('capacity_classroom')->nullable()->after('rate_details');
            }
            if (!Schema::hasColumn('mice_rooms', 'capacity_theatre')) {
                $table->integer('capacity_theatre')->nullable()->after('capacity_classroom');
            }
            if (!Schema::hasColumn('mice_rooms', 'capacity_ushape')) {
                $table->integer('capacity_ushape')->nullable()->after('capacity_theatre');
            }
            if (!Schema::hasColumn('mice_rooms', 'capacity_round')) {
                $table->integer('capacity_round')->nullable()->after('capacity_ushape');
            }
            if (!Schema::hasColumn('mice_rooms', 'capacity_board')) {
                $table->integer('capacity_board')->nullable()->after('capacity_round');
            }
            
            // INI YANG PALING PENTING
            if (!Schema::hasColumn('mice_rooms', 'specifications')) {
                $table->json('specifications')->nullable()->after('capacity_board');
            }

            // Hapus kolom capacity lama jika ada
            if (Schema::hasColumn('mice_rooms', 'capacity')) {
                $table->dropColumn('capacity');
            }
        });
    }

    public function down(): void
    {
        // PERBAIKAN: Cek dulu kolom mana yang eksis sebelum dihapus
        // Agar tidak error "Can't DROP COLUMN" jika kolomnya memang tidak ada.
        $columnsToCheck = [
            'dimension',
            'size_sqm',
            'capacity_classroom',
            'capacity_theatre',
            'capacity_ushape',
            'capacity_round',
            'capacity_board',
            'specifications',
        ];

        $columnsToDrop = [];
        foreach ($columnsToCheck as $col) {
            if (Schema::hasColumn('mice_rooms', $col)) {
                $columnsToDrop[] = $col;
            }
        }

        Schema::table('mice_rooms', function (Blueprint $table) use ($columnsToDrop) {
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Kembalikan kolom capacity jika belum ada
            if (!Schema::hasColumn('mice_rooms', 'capacity')) {
                $table->integer('capacity')->nullable()->after('rate_details');
            }
        });
    }
};