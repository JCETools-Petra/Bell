<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;
use App\Models\Affiliate; // <-- 1. Import the Affiliate model

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'booking_id',
        'amount',
        'status',
    ];

    /**
     * Relationship to the Booking model.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * ==========================================================
     * 2. ADD THIS NEW RELATIONSHIP METHOD
     * ==========================================================
     * Defines the relationship to the Affiliate model.
     */
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }
}