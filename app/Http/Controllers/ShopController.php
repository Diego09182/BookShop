<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

class ShopController extends Controller
{
    public function index(User $shop)
    {
        // 獲取目前使用者訊息
        $user = Auth::user();
        // 獲取特定商家
        $bookshop = User::findOrFail($shop->id);
        // 獲取特定商家的產品
        $products = Product::where('user_id', $shop->id)->paginate(8);

        return view('Shop.shop.index', compact('user','products','bookshop'));
    }
}
