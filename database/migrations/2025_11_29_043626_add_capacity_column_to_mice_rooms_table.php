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
        Schema::table('mice_rooms', function (Blueprint $table) {
            // Menambahkan kolom capacity setelah size_sqm
            $table->integer('capacity')->nullable()->after('size_sqm');
        });
    }
    
    public function down(): void
    {
        Schema::table('mice_rooms', function (Blueprint $table) {
            $table->dropColumn('capacity');
        });
    }
};
