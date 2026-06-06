<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name', 
        'brand_id', 
        'category_id', 
        'price', 
        'discount_percentage', 
        'thumbnail_url', 
        'description'
    ];

    // Relasi ke Model Brand (Menggunakan full namespace untuk mencegah Class not found)
    public function brand()
    {
        return $this->belongsTo(\App\Models\Brand::class, 'brand_id');
    }

    // Relasi ke Model Category
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }
}