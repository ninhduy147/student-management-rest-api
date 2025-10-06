<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LogoutRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);

        $user = User::create($data)->fresh();;
        Log::info('Role sau khi fresh:', ['role' => $user->role]);
        // Thêm vào bảng Student
        if ($user->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'full_name' => $user->name,
                'student_code' => 'STU' . str_pad($user->id, 4, '0', STR_PAD_LEFT)
            ]);
        }
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
