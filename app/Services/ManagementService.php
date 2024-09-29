<?php

namespace App\Services;

use App\Models\User;
use App\Models\Product;
use App\Models\PurchaseRecord;
use Illuminate\Support\Facades\Auth;

class ManagementService
{
    public function index()
    {
        $user = Auth::user();
        
        $userCount = User::count();
        
        $totalSalesQuantity = PurchaseRecord::sum('quantity');

        $totalSalesAmount = PurchaseRecord::sum('total_price');

        if ($user->administration != 5) {
            Auth::logout();
            return redirect()->route('welcome')->with('error', '權限不足，無法進入後台');
        }
        
        $users = User::paginate(8);
        $products = Product::paginate(8);

        return [
            'user' => $user,
            'users' => $users,
            'userCount' => $userCount,
            'totalSalesQuantity' => $totalSalesQuantity,
            'totalSalesAmount' => $totalSalesAmount,
            'products' => $products,
        ];
    }

    public function users()
    {
        $user = Auth::user();
        $userCount = User::count();
        
        $totalSalesQuantity = 0;
        $totalSalesAmount = 0;
        if ($user->administration != 5) {
            Auth::logout();
            return redirect()->route('welcome')->with('error', '權限不足，無法進入後台');
        }
        
        $users = User::paginate(8);

        return [
            'user' => $user,
            'users' => $users,
            'userCount' => $userCount,
            'totalSalesQuantity' => $totalSalesQuantity,
            'totalSalesAmount' => $totalSalesAmount,
        ];
    }

    public function products()
    {
        $user = Auth::user();
        $userCount = User::count();
        
        $totalSalesQuantity = 0;
        $totalSalesAmount = 0;
        if ($user->administration != 5) {
            Auth::logout();
            return redirect()->route('welcome')->with('error', '權限不足，無法進入後台');
        }
        
        $products = Product::paginate(8);

        return [
            'user' => $user,
            'userCount' => $userCount,
            'totalSalesQuantity' => $totalSalesQuantity,
            'totalSalesAmount' => $totalSalesAmount,
            'products' => $products,
        ];
    }

    public function update($request, $user)
    {
        $now_user = Auth::user();
        
        if ($now_user->administration != 5) {
            Auth::logout();
            return redirect()->route('welcome')->with('error', '權限不足，無法進入後台');
        }

        $validatedData = $request->validate([
            'administration' => 'required|integer|min:1|max:5',
            'status' => 'required|integer|in:0,1',
        ], [
            'administration.required' => '請提供管理部門。',
            'administration.integer' => '權限必須是整數。',
            'administration.min' => '權限必須至少為1。',
            'administration.max' => '權限不能超過5。',
            'status.required' => '請提供使用者狀態。',
            'status.integer' => '使用者狀態必須是整數。',
            'status.in' => '使用者狀態必須是0或1。',
        ]);

        $user->update($validatedData);

        return redirect()->route('management.index')->with('success', '使用者權限和停用狀態已成功更新');
    }
}
