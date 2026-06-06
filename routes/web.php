<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminProductController;

// Halaman utama default Laravel (opsional, biarkan jika sudah ada)
Route::get('/', function () {
    return view('welcome');
});

// KODE PERBAIKAN: Rute khusus Web Admin FootFlare
Route::middleware(['web'])->group(function () {
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products/store', [AdminProductController::class, 'store'])->name('admin.products.store');
});