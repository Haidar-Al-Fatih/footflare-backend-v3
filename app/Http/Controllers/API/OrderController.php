<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required'
        ]);

        $user = auth()->user();

        $carts = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Keranjang kosong'
            ], 400);
        }

        $totalPrice = 0;

        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => 1, // sementara default
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'status' => 'Placed'
        ]);

        foreach ($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'size' => $cart->size,
                'quantity' => $cart->quantity,
                'price' => $cart->product->price
            ]);
        }

        Cart::where('user_id', $user->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Checkout berhasil',
            'order_id' => $order->id,
            'total_price' => $totalPrice
        ]);
    }

        public function index()
    {
        $orders = OrderItem::join(
                'orders',
                'order_items.order_id',
                '=',
                'orders.id'
            )
            ->join(
                'products',
                'order_items.product_id',
                '=',
                'products.id'
            )
            ->where('orders.user_id', auth()->id())
            ->select(
                'orders.id as order_id',
                'orders.status',
                'products.name',
                'products.price',
                'products.thumbnail_url',
                'order_items.quantity',
                'order_items.size'
            )
            ->latest('orders.id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}