<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'facilities',
        'image',
        'is_available',
        'meta_description',
        'seo_title',
    ];
    
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}