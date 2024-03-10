<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Evaluation;
use App\Models\Comment;
use App\Models\PurchaseRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        if(empty($search)) {
            $products = Product::latest()->paginate(9);
        } else {
            $products = Product::where('product', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->paginate(9);
        }

        return view('BOOkStore.search', compact('products', 'search'));
    }

    public function filter(Request $request)
    {
        $search = "";

        $filter = $request->input('filter');
        
        if($filter=="觀看次數"){
            // 依照觀看次數排序
            $products = Product::orderBy('view', 'desc')->paginate(9);
        }
        else if($filter=="喜歡次數"){
            // 依照喜歡次數排序
            $products = Product::orderBy('like', 'desc')->paginate(9);
        }

        // 獲取使用者訊息
        $user = Auth::user();
        
        return view('BOOkStore.filter', compact('products', 'filter', 'search'));
    }

    public function addToCart($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        // 檢查商品是否已經在購物車中
        if (isset($cart[$id])) {
            // 如果商品已存在，增加數量
            $cart[$id]['quantity']++;
        } else {
            // 如果商品不存在，新增到購物車
            $cart[$id] = [
                'id' => $product->id,
                'name' => $product->product,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        // 將購物車數據存入 Session
        session()->put('cart', $cart);

        return redirect()->back()->with('success', '商品已添加到購物車。');
    }

    public function removeFromCart(Product $product)
    {
        $cart = session()->get('cart', []);

        // 檢查商品是否在購物車中
        $productId = $product->id;

        if (isset($cart[$productId])) {
            // 如果商品存在，刪除該商品
            unset($cart[$productId]);
            // 將更新後的購物車數據存入 Session
            session()->put('cart', $cart);
            return redirect()->route('product.showCart')->with('success', '商品已從購物車中移除。');
        }

        // 如果商品不存在於購物車，可能需要顯示錯誤或其他處理方式
        return redirect()->route('product.showCart')->with('error', '找不到要移除的商品。');
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);

        // 計算總價
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('BookStore.cart', compact('cart', 'totalPrice'));
    }

    public function purchase()
    {
        // 在此處處理購買的邏輯，例如生成訂單、扣除庫存等等

        // 扣除庫存
        foreach (session('cart') as $productId => $item) {
            $product = Product::findOrFail($productId);
            $product->quantity -= $item['quantity'];
            $product->save();
        }
        
        // 獲取當前認證的使用者資料
        $user = Auth::user();

        // 獲取購物車資訊
        $cart = session('cart', []);

        // 初始化總價
        $totalPrice = 0;

        // 創建購買紀錄
        foreach ($cart as $productId => $item) 
        {
            $totalPrice += $item['price'] * $item['quantity'];
            PurchaseRecord::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'quantity' => $item['quantity'],
                'total_price' => $item['price'] * $item['quantity'],
            ]);
        }

        // 清空購物車SESSION
        session()->forget('cart');

        // 返回帳單視圖，並將使用者資訊、購物車資訊和總價傳遞給視圖
        return view('BookStore.bill', ['user' => $user, 'cart' => $cart, 'totalPrice' => $totalPrice])->with('success', '購買成功！');
    }

    public function like(Product $product)
    {
        $user = auth()->user();

        // 檢查用戶是否已對該產品進行評價，如果已評價則不再允許評價
        $evaluation = Evaluation::where('product_id', $product->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            return back()->with('success', '您已經對該產品進行了評價。');
        }

        // 創建一條喜歡的評價記錄
        Evaluation::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'evaluation' => 1,
        ]);

        // 增加產品的喜歡數量
        $product->increment('like');

        return back()->with('success', '您已成功喜歡該產品。');
    }

    public function dislike(Product $product)
    {
        $user = auth()->user();

        // 檢查用戶是否已對該產品進行評價，如果已評價則不再允許評價
        $evaluation = Evaluation::where('product_id', $product->id)
            ->where('user_id', $user->id)
            ->first();

        if ($evaluation) {
            return back()->with('success', '您已經對該產品進行了評價。');
        }

        // 創建一條不喜歡的評價記錄
        Evaluation::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'evaluation' => -1,
        ]);

        // 增加產品的不喜歡數量
        $product->increment('dislike');

        return back()->with('success', '您已成功不喜歡該產品。');
    }

    public function index()
    {
        $products = Product::paginate(8);

        return view('BookStore.index', compact('products'));
    }

    public function create()
    {
        return view('BookStore.create');
    }

    public function store(Request $request)
    {
        // 取得目前使用者
        $user = Auth::user();

        $request->validate([
            'product' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'quality' => 'required|string',
            'description' => 'required|string',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'product.required' => '請輸入產品名稱',
            'product.string' => '產品名稱必須是文字',
            'price.required' => '請輸入價格',
            'price.numeric' => '價格必須是數字',
            'quantity.required' => '請輸入數量',
            'quantity.integer' => '數量必須是整數',
            'quality.required' => '請輸入品質',
            'quality.string' => '品質必須是文字',
            'description.required' => '請輸入描述',
            'description.string' => '描述必須是文字',
            'product_image.image' => '上傳的文件必須是圖片',
            'product_image.mimes' => '只支援jpeg, png, jpg, gif格式的圖片',
            'product_image.max' => '圖片大小不能超過2048KB',
        ]);

        // 創建一個新的產品實例
        $product = new Product;

        // 設置產品屬性
        $product->product = $request->input('product');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->quality = $request->input('quality');
        $product->description = $request->input('description');

        // 將當前使用者的 ID 加入要存入資料庫的資料
        $product->user_id = $user->id;

        // 處理商品圖片上傳
        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $imagePath = 'product_images/' . $imageName;
            // 將上傳的圖片存儲到 storage 目錄中
            Storage::putFileAs('public', $image, $imagePath);
            // 將圖片名稱和路徑加入要存入資料庫的資料
            $product->image_name = $imageName;
            $product->image_path = $imagePath;
        }

        // 儲存產品到資料庫
        $product->save();

        return redirect()->route('product.index')->with('success', '商品創建成功');
    }

    public function show($id)
    {
        // 取得商品資訊，同時載入相關聯的評論
        $product = Product::with('comments')->findOrFail($id);

        // 增加商品的觀看次數
        $product->increment('view');

        // 取得商品的評論
        $comments = Comment::where('product_id', $id)->paginate(10);

        // 傳遞商品和評論到視圖
        return view('BookStore.show', compact('product', 'comments'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('BookStore.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'quality' => 'required|string',
            'description' => 'required|string',
            'user_id' => 'required|exists:users,id',
        ], [
            'product.required' => '請輸入產品名稱',
            'product.string' => '產品名稱必須是文字',
            'price.required' => '請輸入價格',
            'price.numeric' => '價格必須是數字',     
            'quantity.required' => '請輸入數量',
            'quantity.integer' => '數量必須是整數',
            'quality.required' => '請輸入品質',
            'quality.string' => '品質必須是文字',
            'description.required' => '請輸入描述',
            'description.string' => '描述必須是文字',
            'user_id.required' => '請選擇使用者',
            'user_id.exists' => '所選擇的使用者不存在',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('product.index')->with('success', '商品更新成功');
    }

    public function destroy($id)
    {
        // 獲取當前登入的使用者
        $now_user = Auth::user();

        if ($now_user->administration != 5) {
            Auth::logout(); // 登出使用者
            return redirect()->route('welcome')->with('error', '權限不足，無法執行此操作');
        }

        $product = Product::findOrFail($id);

        // 檢查該產品的 user_id 是否與目前登入的使用者的 id 相同
        if ($product->user_id !== $now_user->id) {
            return redirect()->back()->with('error', '您無權刪除該產品');
        }

        $product->delete();

        return redirect()->back()->with('success', '商品刪除成功');
    }

}
