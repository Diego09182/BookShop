<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class CartService
{
    protected function getCartKey()
    {
        return 'cart_' . Auth::id();
    }

    public function showCart()
    {
        $user = Auth::user();
        
        if (!$user) {
            return view('Shop.cart', [
                'products' => [],
                'cart' => [],
                'totalPrice' => 0,
            ]);
        }

        $cart = Cache::get($this->getCartKey(), []);
    
        if (empty($cart)) {
            return view('Shop.cart', [
                'products' => [],
                'cart' => $cart,
                'totalPrice' => 0,
            ]);
        }
    
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();
    
        $totalPrice = 0;
        foreach ($products as $product) {
            $product->quantity_in_cart = $cart[$product->id]['quantity'];
            $totalPrice += $product->price * $product->quantity_in_cart;
        }
    
        return view('Shop.cart', [
            'products' => $products,
            'cart' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        ]);

        $quantity = $request->input('quantity');

        $cart = Cache::get($this->getCartKey(), []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->product,
                'quantity' => $quantity,
                'price' => $product->price,
            ];
        }

        Cache::put($this->getCartKey(), $cart, now()->addHour());

        return redirect()->route('product.showCart')->with('success', '商品已添加到購物車');
    }

    public function removeFromCart(Product $product)
    {
        $cart = Cache::get($this->getCartKey(), []);

        if (isset($cart[$product->id])) {

            unset($cart[$product->id]);
            
            Cache::put($this->getCartKey(), $cart, now()->addHour());
            
            return redirect()->route('product.showCart')->with('success', '商品已從購物車中移除。');
        }

        return redirect()->route('product.showCart')->with('error', '找不到要移除的商品。');
    }
}
