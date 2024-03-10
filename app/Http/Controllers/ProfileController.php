<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PurchaseRecord;
use App\Models\Product;

class ProfileController extends Controller
{
    public function index()
    {
        // 獲取使用者訊息
        $user = Auth::user();
        
        // 獲取使用者的購買紀錄
        $purchaseRecords = PurchaseRecord::where('user_id', $user->id)->paginate(8);

        // 獲取銷售
        $totalSalesQuantity = PurchaseRecord::where('user_id', $user->id)->sum('quantity');

        // 獲取銷售額
        $totalSalesAmount = PurchaseRecord::where('user_id', $user->id)->sum('total_price');

        // 獲取使用者所發佈的產品種類
        $productClass = Product::where('user_id', $user->id)->count();

        // 返回使用者訊息、購買紀錄、銷售數量和銷售額，並將其傳遞到視圖
        return view('BookStore.profile.index', [
            'user' => $user,
            'purchaseRecords' => $purchaseRecords,
            'totalSalesQuantity' => $totalSalesQuantity,
            'totalSalesAmount' => $totalSalesAmount,
            'productClass' => $productClass,
        ]);
    }

    public function update(Request $request)
    {
        // 驗證表單數據
        $validatedData = $request->validate([
            'new_password' => 'nullable|string|min:8|max:15|different:password',
            'name' => 'required|string|min:1|max:8',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'cellphone' => 'required|digits:10|unique:users,cellphone,'.Auth::user()->id,
            'birthday' => 'required|date_format:Y-m-d',
            'business_name' => 'nullable|string|max:255',
            'business_description' => 'nullable|string',
            'product_quantity' => 'nullable|integer|min:0',
            'business_address' => 'nullable|string|max:255',
            'business_website' => 'nullable|url|max:255',
        ], [
            'new_password.string' => '新密碼必須是字串',
            'new_password.min' => '新密碼長度不能少於8個字',
            'new_password.max' => '新密碼長度不能超過15個字',
            'new_password.different' => '新密碼不能與舊密碼相同',
            'name.required' => '請填寫姓名',
            'name.string' => '姓名必須是字串',
            'name.min' => '姓名長度不能少於1個字',
            'name.max' => '姓名長度不能超過8個字',
            'email.required' => '請填寫郵箱',
            'email.email' => '請填寫有效的郵箱地址',
            'email.unique' => '該郵箱已經被使用',
            'cellphone.required' => '請填寫手機號碼',
            'cellphone.digits' => '手機號碼必須是10位數字',
            'cellphone.unique' => '該手機號碼已經被使用',
            'birthday.required' => '請填寫生日',
            'birthday.date_format' => '生日必須符合Y-m-d格式',
            'business_name.string' => '業務名稱必須是字串',
            'business_name.max' => '業務名稱長度不能超過255個字',
            'business_description.string' => '業務描述必須是字串',
            'product_quantity.integer' => '產品數量必須是整數',
            'product_quantity.min' => '產品數量不能小於0',
            'business_address.string' => '業務地址必須是字串',
            'business_address.max' => '業務地址長度不能超過255個字',
            'business_website.url' => '業務網站必須是有效的 URL',
            'business_website.max' => '業務網站長度不能超過255個字',
        ]);
    

        // 獲取使用者實例
        $user = Auth::user();

        // 更新使用者數據
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->cellphone = $validatedData['cellphone'];
        $user->birthday = $validatedData['birthday'];

        // 如果新密碼不為空，更新密碼
        if (!empty($validatedData['new_password'])) {
            $user->password = bcrypt($validatedData['new_password']);
        }

        // 更新業務相關數據
        $user->business_name = $request->input('business_name');
        $user->business_description = $request->input('business_description');
        $user->product_quantity = $request->input('product_quantity');
        $user->business_address = $request->input('business_address');
        $user->business_website = $request->input('business_website');

        // 保存使用者數據
        $user->save();
        
        // 重定向到使用者資料頁面或其他頁面
        return redirect()->route('profile.index')->with('success', '使用者資料已更新');
    }


}