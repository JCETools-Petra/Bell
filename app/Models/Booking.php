<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'guest_name',
        'guest_phone',
        'guest_email',
        'checkin_date',
        'checkout_date',
        'num_rooms',
        'status',
    ];

    /**
     * Mendefinisikan bahwa sebuah booking dimiliki oleh satu room.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}