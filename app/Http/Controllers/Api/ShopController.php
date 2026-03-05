<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    // 1. عرض كل المحلات
    public function index()
    {
        $shops = Shop::where('is_open', true)->get();
        return response()->json($shops);
    }

    // 2. دالة إنشاء المحل (التي كانت ناقصة)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // إنشاء المحل وربطه بالمستخدم المسجل دخوله حالياً
        $shop = Shop::create([
            'user_id' => auth()->id(), 
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'is_open' => true,
        ]);

        return response()->json([
            'message' => 'تم إنشاء المحل بنجاح',
            'shop' => $shop
        ], 201);
    }
}