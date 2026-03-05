<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // وظيفة تسجيل مستخدم جديد (Customer بالوضع الافتراضي)
    public function register(Request $request)
    {
        
        // 1. التحقق من البيانات المدخلة (Validation)
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. إنشاء المستخدم في قاعدة البيانات
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), // تشفير كلمة المرور
            'role' => 'customer', // القيمة الافتراضية
        ]);

        // 3. إنشاء التوكن (Token) لهذا المستخدم
        $token = $user->createToken('auth_token')->plainTextToken;

        // 4. إرجاع النتيجة للتطبيق
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    // وظيفة تسجيل الدخول
   public function login(Request $request)
{
    // التأكد من وجود المستخدم بالبريد الإلكتروني
    $user = User::where('email', $request->email)->first();

    // التحقق: هل المستخدم موجود؟ وهل كلمة المرور (بعد فك تشفيرها) مطابقة؟
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'بيانات الدخول غير صحيحة'], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user,
    ]);
}
}