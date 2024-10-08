<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // 處理註冊請求
    public function register(Request $request)
    {
        // 驗證使用者輸入
        $validatedData = $request->validate([
            'account' => 'required|string|min:5|max:8|unique:users',
            'password' => 'required|string|min:8|max:15',
            'name' => 'required|string|min:1|max:8',
            'email' => 'required|email|unique:users',
            'cellphone' => 'required|unique:users|digits:10',
            'birthday' => 'required|date_format:Y-m-d',
            'business_name' => 'nullable|string|max:255',
            'business_description' => 'nullable|string|max:255',
            'business_address' => 'nullable|string|max:255',
            'business_website' => 'nullable|url|max:255',
        ], [
            'account.required' => '請填寫帳號',
            'account.string' => '帳號必須是字串',
            'account.min' => '帳號長度不能少於5個字',
            'account.max' => '帳號長度不能超過8個字',
            'account.unique' => '該帳號已經被使用',
            'password.required' => '請填寫密碼',
            'password.string' => '密碼必須是字串',
            'password.min' => '密碼長度不能少於8個字',
            'password.max' => '密碼長度不能超過15個字',
            'name.required' => '請填寫姓名',
            'name.min' => '帳號長度不能少於1個字',
            'name.max' => '帳號長度不能超過8個字',
            'email.required' => '請填寫郵箱',
            'email.email' => '請填寫有效的郵箱地址',
            'email.unique' => '該郵箱已經被使用',
            'cellphone.required' => '請填寫手機號碼',
            'cellphone.digits' => '手機號碼必須是10位數字',
            'cellphone.unique' => '該手機號碼已經被使用',
            'birthday.required' => '請填寫生日',
            'business_name.max' => '商家名稱長度不能超過255個字',
            'business_description.max' => '商家簡介長度不能超過255個字',
            'business_address.max' => '商家地址長度不能超過255個字',
            'business_website.url' => '商家網址格式不正確',
            'business_website.max' => '商家網址長度不能超過255個字',
        ]);

        $user = $this->authService->registerUser($validatedData, $request);

        if ($user) {
            Auth::login($user);
            return redirect()->route('product.index')->with('success', '註冊成功！');
        } else {
            return back()->with('error', '註冊失敗，請稍後再試');
        }
    }

    // 處理登入請求
    public function login(Request $request)
    {
        $credentials = $request->only('account', 'password');

        $result = $this->authService->login($credentials);

        if ($result['success']) {
            return redirect()->route('product.index')->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    // 處理登出請求
    public function logout()
    {
        $result = $this->authService->logout();

        if ($result['success']) {
            return redirect()->route('welcome')->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }
}
