<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\PurchaseRecord;
use App\Models\Product;

class ProfileService
{
    public function index()
    {
        $user = Auth::user();

        $purchaseRecords = PurchaseRecord::where('user_id', $user->id)->paginate(8);
        $totalSalesQuantity = PurchaseRecord::where('user_id', $user->id)->sum('quantity');
        $totalSalesAmount = PurchaseRecord::where('user_id', $user->id)->sum('total_price');
        $productClass = Product::where('user_id', $user->id)->count();

        return view('Shop.profile.index', [
            'user' => $user,
            'purchaseRecords' => $purchaseRecords,
            'totalSalesQuantity' => $totalSalesQuantity,
            'totalSalesAmount' => $totalSalesAmount,
            'productClass' => $productClass,
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'new_password' => 'nullable|string|min:8|max:15|different:password',
            'name' => 'required|string|min:1|max:8',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'cellphone' => 'required|digits:10|unique:users,cellphone,' . Auth::id(),
            'birthday' => 'required|date_format:Y-m-d',
            'business_name' => 'nullable|string|max:255',
            'business_description' => 'nullable|string',
            'product_quantity' => 'nullable|integer|min:0',
            'business_address' => 'nullable|string|max:255',
            'business_website' => 'nullable|url|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'avatar.image' => '头像必须是图片',
            'avatar.mimes' => '头像必须是jpeg, png, jpg, gif格式',
            'avatar.max' => '头像大小不能超过2MB',
        ]);

        $user = Auth::user();

        if (!empty($validatedData['new_password'])) {
            $user->password = bcrypt($validatedData['new_password']);
        }

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->cellphone = $validatedData['cellphone'];
        $user->birthday = $validatedData['birthday'];
        $user->business_name = $validatedData['business_name'] ?? null;
        $user->business_description = $validatedData['business_description'] ?? null;
        $user->business_address = $validatedData['business_address'] ?? null;
        $user->business_website = $validatedData['business_website'] ?? null;

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time().'.'.$avatar->getClientOriginalExtension();
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
            $user->avatar = '/storage/'.$avatarPath;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', '使用者資料已更新');
    }
}
