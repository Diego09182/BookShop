<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;

class MainController extends Controller
{
    public function index(Request $request)
    {
        // 獲取使用者訊息
        $user = Auth::user();

        $page = $request->input('page', 1);
        $cacheKey = 'products_page_' . $page;

        $products = Cache::remember($cacheKey, 600, function() {
            return Product::paginate(8);
        });

        return view('Shop.index', compact('products','user'));
    }
}
