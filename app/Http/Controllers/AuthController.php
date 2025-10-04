<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']); // mã hoá mật khẩu

        $user = User::create($data);

        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            'status'  => 201,
            'message' => 'Đăng ký thành công',
            'user'    => $user,
            'token'   => $token,
        ], 201);
    }


    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'status'  => 401,
                'message' => 'Tài khoản hoặc mật khẩu không đúng!',
            ], 401);
        }

        $token = $user->createToken('login_token')->plainTextToken;

        return response()->json([
            'status'  => 200,
            'message' => 'Đăng nhập thành công',
            'user'    => $user,
            'token'   => $token,
        ], 200);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return response()->json([
                'message' => 'Tài khoản đã đăng xuất',
            ]);
    }
}
