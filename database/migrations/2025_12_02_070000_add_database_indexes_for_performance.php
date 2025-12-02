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
        // Add indexes to bookings table for frequently queried columns
        Schema::table('bookings', function (Blueprint $table) {
            $table->index('status');
            $table->index('payment_status');
            $table->index('check_in_date');
            $table->index('check_out_date');
            $table->index(['check_in_date', 'check_out_date'], 'bookings_date_range_index');
        });

        // Add indexes to commissions table
        Schema::table('commissions', function (Blueprint $table) {
            $table->index('status');
        });

        // Add indexes to recreation_areas table
        Schema::table('recreation_areas', function (Blueprint $table) {
            $table->index('order');
            $table->index('is_active');
        });

        // Add indexes to rooms table
        Schema::table('rooms', function (Blueprint $table) {
            $table->index('is_available');
        });

        // Add index to mice_rooms table if is_available column exists
        if (Schema::hasColumn('mice_rooms', 'is_available')) {
            Schema::table('mice_rooms', function (Blueprint $table) {
                $table->index('is_available');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes from bookings table
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['payment_status']);
            $table->dropIndex(['check_in_date']);
            $table->dropIndex(['check_out_date']);
            $table->dropIndex('bookings_date_range_index');
        });

        // Drop indexes from commissions table
        Schema::table('commissions', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        // Drop indexes from recreation_areas table
        Schema::table('recreation_areas', function (Blueprint $table) {
            $table->dropIndex(['order']);
            $table->dropIndex(['is_active']);
        });

        // Drop indexes from rooms table
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropIndex(['is_available']);
        });

        // Drop index from mice_rooms table if is_available column exists
        if (Schema::hasColumn('mice_rooms', 'is_available')) {
            Schema::table('mice_rooms', function (Blueprint $table) {
                $table->dropIndex(['is_available']);
            });
        }
    }
};
