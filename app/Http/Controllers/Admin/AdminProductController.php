<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        // Mengambil produk terbaru untuk ditampilkan pada tabel admin
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // Validasi data input form sesuai dengan tipe data di phpMyAdmin
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|integer', // Sesuai kolom brand_id di database
            'category_id' => 'required|integer', // Sesuai kolom category_id di database
            'price' => 'required|numeric',
            'discount_percentage' => 'nullable|integer|min:0|max:100', // Sesuai kolom discount_percentage
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Untuk thumbnail_url
        ]);

        // 1. Proses upload file gambar fisik ke dalam folder local storage server Laravel
        $imagePath = $request->file('thumbnail')->store('products', 'public');

        // 2. Simpan data ke database dengan nama kolom yang 100% presisi sesuai gambar image_d69628.png
        Product::create([
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'discount_percentage' => $request->discount_percentage ?? 0, // Jika kosong, set jadi 0
            'thumbnail_url' => 'storage/' . $imagePath, // Mengisi kolom thumbnail_url
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk sepatu baru berhasil disimpan ke database FootFlare!');
    }
}