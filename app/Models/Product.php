<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'brand_id', 
        'category_id', 
        'price', 
        'discount_percentage', 
        'thumbnail_url', 
        'description'
    ];

    public function getThumbnailUrlFullAttribute()
    {
        $value = $this->attributes['thumbnail_url'] ?? null;

        if (!$value) {
            return null;
        }

        if (preg_match('/^(https?:\/\/|data:)/', $value)) {
            return $value;
        }

        if (file_exists(public_path($value))) {
            return asset($value);
        }

        if (file_exists(public_path('storage/' . ltrim($value, '/')))) {
            return asset('storage/' . ltrim($value, '/'));
        }

        if (file_exists(public_path('storage/products/' . ltrim($value, '/')))) {
            return asset('storage/products/' . ltrim($value, '/'));
        }

        if (strpos($value, 'assets/') === 0) {
            return asset($value);
        }

        return asset('storage/' . ltrim($value, '/'));
    }

    /**
     * Relasi ke tabel Brand (Satu produk memiliki satu Brand)
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Relasi ke tabel Category (Satu produk memiliki satu Category)
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}