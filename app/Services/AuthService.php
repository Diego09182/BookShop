<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    public function registerUser(array $validatedData, $request)
    {
        return User::create([
            'account' => $validatedData['account'],
            'password' => Hash::make($validatedData['password']),
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'cellphone' => $validatedData['cellphone'],
            'birthday' => $validatedData['birthday'],
            'ip_address' => $request->ip(),
            'business_name' => $validatedData['business_name'],
            'business_description' => $validatedData['business_description'],
            'business_address' => $validatedData['business_address'],
            'business_website' => $validatedData['business_website'],
        ]);
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'message' => '登入失敗，請檢查帳號與密碼'
            ];
        }

        $user = Auth::user();

        if ($user->status == 0) {
            Auth::logout();
            return [
                'success' => false,
                'message' => '登入失敗，帳號已停用'
            ];
        }

        $user->increment('times');

        return [
            'success' => true,
            'message' => '登入成功'
        ];
    }

    public function logout()
    {
        Auth::logout();
        return [
            'success' => true,
            'message' => '登出成功'
        ];
    }
}

