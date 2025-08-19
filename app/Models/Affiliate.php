<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'referral_code',
        'status',
        'commission_rate',
    ];

    /**
     * Relasi ke model User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ==========================================================
     * TAMBAHKAN METODE BARU DI BAWAH INI
     * ==========================================================
     * Mendefinisikan bahwa seorang affiliate memiliki banyak komisi.
     */
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
}