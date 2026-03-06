<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shop_id' => 'required|exists:shops,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'delivery_fee' => 'required|numeric',
            'total_price' => 'required|numeric',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                $order = Order::create([
                    'customer_id' => auth()->id(),
                    'shop_id' => $request->shop_id,
                    'subtotal' => $request->subtotal,
                    'delivery_fee' => $request->delivery_fee,
                    'total_price' => $request->total_price,
                    'status' => 'pending',
                ]);

                foreach ($request->items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);
                }

                return response()->json([
                    'message' => 'Order placed successfully!',
                    'order_id' => $order->id
                ], 201);
            });
            
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}