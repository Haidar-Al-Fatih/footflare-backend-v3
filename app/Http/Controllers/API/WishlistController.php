<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // 1. Mengambil semua daftar produk yang di-wishlist oleh user yang sedang login
    public function index()
    {
        try {
            $user = Auth::user();
            
            // Ambil data wishlist beserta relasi produk, brand, dan category
            $wishlists = Wishlist::with(['product.brand', 'product.category'])
                ->where('user_id', $user->id)
                ->get();

            // Transformasi format agar Flutter menerima langsung array list produk dengan relasi lengkap
            $products = $wishlists->map(function ($item) {
                if ($item->product) {
                    $item->product->is_wishlist = true; // Flag penanda untuk di frontend
                    return $item->product;
                }
                return null;
            })->filter()->values();

            return response()->json([
                'success' => true,
                'message' => 'Daftar wishlist berhasil diambil',
                'data' => $products
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 2. Fungsi Tambah / Hapus Wishlist otomatis (Toggle)
    public function toggle(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:products,id',
            ]);

            $user = Auth::user();
            $productId = $request->product_id;

            $existingWishlist = Wishlist::where('user_id', $user->id)
                                        ->where('product_id', $productId)
                                        ->first();

            if ($existingWishlist) {
                $existingWishlist->delete();
                return response()->json([
                    'success' => true,
                    'is_wishlist' => false,
                    'message' => 'Produk dihapus dari wishlist'
                ], 200);
            } else {
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => $productId
                ]);
                return response()->json([
                    'success' => true,
                    'is_wishlist' => true,
                    'message' => 'Produk berhasil ditambahkan ke wishlist'
                ], 201);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status wishlist',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}