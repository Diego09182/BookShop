<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\PurchaseRecord;

class PurchaseService
{
    protected $cartKey;

    public function __construct()
    {
        $this->cartKey = 'cart_' . Auth::id();
    }

    public function purchase()
    {
        $this->cartKey = 'cart_' . Auth::id();

        $cart = Cache::get($this->cartKey, []);

        if (empty($cart)) {
            return redirect()->back()->with('error', '購物車為空，無法完成購買。');
        }

        DB::beginTransaction();

        try {
            foreach ($cart as $productId => $item) {

                $product = Product::findOrFail($productId);

                if ($product->quantity < $item['quantity']) {
                    return redirect()->back()->with('error', '庫存不足，無法完成購買。');
                }

                $product->quantity -= $item['quantity'];

                $product->save();
            }

            $user = Auth::user();

            $totalPrice = 0;

            foreach ($cart as $productId => $item) 
            {
                $totalPrice += $item['price'] * $item['quantity'];
                
                Order::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);

                PurchaseRecord::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);
            }

            Cache::forget($this->cartKey);

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();
            
            return redirect()->back()->with('error', '購買過程中發生錯誤，請稍後再試。');
        }

        return view('Shop.bill', ['user' => $user, 'cart' => $cart, 'totalPrice' => $totalPrice])->with('success', '購買成功！');
    }
}
