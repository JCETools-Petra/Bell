<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiceInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'mice_room_id',
        'affiliate_id',
        'mice_kit_id',
        'customer_name',
        'customer_phone',
        'event_type',
        'event_other_description',
        'event_date',
        'pax',
        'total_price',
        'status',
    ];

    public function miceRoom()
    {
        return $this->belongsTo(MiceRoom::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function miceKit()
    {
        return $this->belongsTo(MiceKit::class);
    }
}