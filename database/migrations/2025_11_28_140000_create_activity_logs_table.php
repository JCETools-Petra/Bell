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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // User yang melakukan aksi
            $table->string('action'); // Jenis aksi: 'booking_status_changed', 'booking_deleted', 'commission_paid', dll
            $table->string('model_type')->nullable(); // Nama model: 'Booking', 'Commission', dll
            $table->unsignedBigInteger('model_id')->nullable(); // ID dari model
            $table->text('description'); // Deskripsi detail dari aksi
            $table->json('old_values')->nullable(); // Nilai lama (untuk update)
            $table->json('new_values')->nullable(); // Nilai baru (untuk update)
            $table->ipAddress('ip_address')->nullable(); // IP address user
            $table->string('user_agent')->nullable(); // User agent browser
            $table->timestamps();

            // Index untuk pencarian cepat
            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
