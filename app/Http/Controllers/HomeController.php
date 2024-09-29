<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // 獲取使用者訊息
        $user = Auth::user();

        // 返回文章列表，並將分頁結果傳遞到視圖
        return view('Shop.profile.index', ['user' => $user]);
    }
}
