<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Menampilkan keranjang
    public function index()
    {
        $cart = Cart::with('product')
            ->where('user_id', auth()->id())
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cart
        ]);
    }

    // Tambah ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'size' => 'required',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
            'size' => $request->size,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product successfully added to cart',
            'data' => $cart
        ]);
    }

    // Hapus item keranjang
    public function destroy($id)
    {
        $cart = Cart::where('user_id', auth()->id())
                    ->findOrFail($id);

        $cart->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item successfully removed from cart'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::where('user_id', auth()->id())
                    ->findOrFail($id);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quantity successfully updated',
            'data' => $cart
        ]);
    }
}