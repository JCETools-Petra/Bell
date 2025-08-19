<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Menambahkan kolom untuk menyimpan konten Terms and Conditions
            // Tipe 'longText' digunakan untuk menampung teks yang sangat panjang
            $table->longText('terms_and_conditions')->nullable()->after('contact_tiktok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Menghapus kolom jika migrasi di-rollback
            $table->dropColumn('terms_and_conditions');
        });
    }
};