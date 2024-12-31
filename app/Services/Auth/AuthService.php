<?php

namespace App\Services\Auth;

use App\Http\Requests\Dashboard\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function login(LoginRequest $request)
    {
        $data = $request->validated();
        if(!Auth::attempt(['username' => $data['username'], 'password' => $data['password']])) {
            return response()->json([
                "status" => false,
                "message" => "البريد الالكتروني او كلمه المرور غير صحيحه"
            ],401);
        }
        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        $user["token"] = $token;
        return response()->json([
            "status" => true,
            "message" => "مرحبا ممجددا",
            "data" => $user
        ]);    }
}
