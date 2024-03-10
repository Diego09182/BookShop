<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\PurchaseRecord;
use App\Models\ProductImage;

class ManagementController extends Controller
{
    public function index()
    {
        // 獲取當前登入的使用者
        $user = Auth::user();

        // 使用者數量
        $userCount = User::count();
        
        // 獲取產品數量
        $productCount = Product::count();

        // 獲取銷售
        $totalSalesQuantity = PurchaseRecord::sum('quantity');

        // 獲取銷售額
        $totalSalesAmount = PurchaseRecord::sum('total_price');

        if ($user->administration != 5) {
            Auth::logout(); // 登出使用者
            return redirect()->route('welcome')->with('error', '權限不足，無法進入後台');
        }

        // 獲取所有使用者，每頁8筆資料
        $users = User::paginate(8);

        // 獲取所有產品，每頁8筆資料
        $products = Product::paginate(8);

        // 返回視圖，並將使用者資訊、所有使用者、最新的公告和檢舉資料以及產品資訊傳遞到視圖
        return view('BookStore.management.index', [
            'user' => $user,
            'users' => $users,
            'userCount' => $userCount,
            'totalSalesQuantity' => $totalSalesQuantity,
            'totalSalesAmount' => $totalSalesAmount,
            'products' => $products,
        ]);
    }

    public function update(Request $request, User $user)
    {

        // 獲取當前登入的使用者
        $now_user = Auth::user();

        if ($now_user->administration!=5) {
            Auth::logout(); // 登出使用者
            return redirect()->route('welcome')->with('error', '權限不足，無法進入後台');
        }

        // 驗證請求中的數據
        $validatedData = $request->validate([
            'administration' => 'required|integer|min:1|max:5',
            'status' => 'required|integer|in:0,1',
        ]);

        // 更新使用者權限
        $user->update([
            'administration' => $validatedData['administration'],
            'status' => $validatedData['status'],
        ]);

        // 重定向回使用者管理頁面
        return redirect()->route('management.index')->with('success', '使用者權限和停用狀態已成功更新');
    }

}
