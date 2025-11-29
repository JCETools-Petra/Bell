<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiceRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'dimension',
        'size_sqm',
        'capacity',
        'rate_details',
        'capacity_classroom',
        'capacity_theatre',
        'capacity_ushape',
        'capacity_round',
        'capacity_board',
        'description',
        'facilities',
        'image',
        'is_available',
        'seo_title',
        'meta_description',
        'specifications', // <--- WAJIB ADA: Agar layout specs bisa disimpan
    ];

    // Casting otomatis agar specifications langsung jadi Array (bukan String JSON)
    // dan is_available jadi boolean true/false
    protected $casts = [
        'specifications' => 'array',
        'is_available' => 'boolean',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}