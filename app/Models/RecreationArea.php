<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RecreationArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationship dengan images
    public function images()
    {
        return $this->hasMany(RecreationAreaImage::class)->orderBy('order');
    }

    // Auto generate UNIQUE slug dari name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recreationArea) {
            if (empty($recreationArea->slug)) {
                $recreationArea->slug = static::generateUniqueSlug($recreationArea->name);
            }
        });

        static::updating(function ($recreationArea) {
            if ($recreationArea->isDirty('name')) {
                $recreationArea->slug = static::generateUniqueSlug($recreationArea->name, $recreationArea->id);
            }
        });
    }

    /**
     * Generate unique slug
     */
    protected static function generateUniqueSlug($name, $ignoreId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (true) {
            $query = static::where('slug', $slug);
            
            if ($ignoreId) {
                $query->where('id', '!=', $ignoreId);
            }
            
            if (!$query->exists()) {
                break;
            }
            
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
