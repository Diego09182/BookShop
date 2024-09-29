<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Comment;

class ProductService
{
    // 搜尋產品
    public function search(Request $request)
    {
        $search = $request->input('search');
        $cacheKey = 'search_' . md5($search);

        $products = Cache::remember($cacheKey, 600, function() use ($search) {
            $query = Product::query();

            if (!empty($search)) {
                $query->where('product', 'LIKE', "%$search%")
                      ->orWhere('description', 'LIKE', "%$search%");
            }

            return $query->paginate(9);
        });

        return view('Shop.search', compact('products', 'search'));
    }

    // 篩選產品
    public function filter(Request $request)
    {
        $filter = $request->input('filter');
        $cacheKey = 'filter_' . md5($filter);

        $products = Cache::remember($cacheKey, 600, function() use ($filter) {
            $query = Product::query();

            if ($filter == "觀看次數") {
                $query->orderBy('view', 'desc');
            } else if ($filter == "喜歡次數") {
                $query->orderBy('like', 'desc');
            }

            return $query->paginate(9);
        });

        return view('Shop.filter', compact('products', 'filter'));
    }

    // 顯示產品列表
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->input('page', 1);
        $cacheKey = 'products_page_' . $page;

        $products = Cache::remember($cacheKey, 600, function() {
            return Product::paginate(8);
        });

        return view('Shop.index', compact('products','user'));
    }

    // 顯示創建產品表單
    public function create()
    {
        $user = Auth::user();
        
        if($user->administration != 5)
        {
            return redirect()->back()->with('error', '權限錯誤');
        }

        return view('Shop.create');
    }

    // 儲存新產品
    public function store(Request $request)
    {
        $user = Auth::user();

        if($user->administration != 5)
        {
            return redirect()->back()->with('error', '權限錯誤');
        }

        $request->validate([
            'product' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'quality' => 'required|string',
            'description' => 'required|string',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'product.required' => '請輸入產品名稱。',
            'price.required' => '請輸入產品價格。',
            'price.numeric' => '價格必須是數字。',
            'quantity.required' => '請輸入產品數量。',
            'quantity.integer' => '數量必須是整數。',
            'quality.required' => '請輸入產品品質。',
            'description.required' => '請輸入產品描述。',
            'product_image.image' => '上傳的文件必須是一張圖片。',
            'product_image.mimes' => '圖片格式必須是 jpeg, png, jpg 或 gif。',
            'product_image.max' => '圖片大小不可超過 2MB。',
        ]);

        $data = $request->only(['product', 'price', 'quantity', 'quality', 'description']);
        $data['user_id'] = $user->id;

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $imagePath = $image->storeAs('public/product_images', $imageName);

            if ($imagePath) {
                $data['image_name'] = $imageName;
                $data['image_path'] = $imagePath;
            } else {
                return redirect()->back()->with('error', '圖片儲存失敗，請重試');
            }
        }

        DB::beginTransaction();

        try {
            // 儲存產品
            Product::create($data);

            // 提交交易
            DB::commit();

            // 清除相關快取
            $this->clearProductCache();

            return redirect()->route('product.index')->with('success', '商品創建成功');
        } catch (\Exception $e) {
            DB::rollBack();

            // 刪除已上傳的圖片
            if (isset($data['image_path'])) {
                Storage::delete($data['image_path']);
            }

            return redirect()->back()->with('error', '商品創建失敗，請重試');
        }
    }

    // 顯示單一產品詳細資訊
    public function show($id)
    {
        $cacheKey = 'product_' . $id;

        $product = Cache::remember($cacheKey, 600, function() use ($id) {
            return Product::findOrFail($id);
        });

        $product->increment('view');

        $comments = Comment::where('product_id', $id)->paginate(8);

        return view('Shop.show', compact('product', 'comments'));
    }

    // 顯示編輯產品表單
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('Shop.edit', compact('product'));
    }

    // 更新產品資訊
    public function update(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->administration != 5) {
            Auth::logout();
            return redirect()->route('welcome')->with('error', '權限不足，無法執行此操作');
        }

        $request->validate([
            'product' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'quality' => 'required|string',
            'description' => 'required|string',
            'product_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);        

        $product = Product::findOrFail($id);

        $data = $request->only(['product', 'price', 'quantity', 'quality', 'description']);

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
            $imagePath = $image->storeAs('public/product_images', $imageName);

            if ($imagePath) {
                $data['image_name'] = $imageName;
                $data['image_path'] = $imagePath;
            } else {
                return redirect()->back()->with('error', '圖片儲存失敗，請重試');
            }
        }

        DB::beginTransaction();

        try {
            // 更新產品
            $product->update($data);

            // 提交交易
            DB::commit();

            // 清除相關快取
            $this->clearProductCache($id);

            return redirect()->route('product.index')->with('success', '商品更新成功');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', '商品更新失敗，請重試');
        }
    }

    // 刪除產品
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        if ($user->administration != 5 || $product->user_id !== $user->id) {
            return redirect()->back()->with('error', '權限不足，無法執行此操作');
        }

        DB::beginTransaction();

        try {
            Storage::delete($product->image_path);
            $product->delete();

            // 提交交易
            DB::commit();

            // 清除相關快取
            $this->clearProductCache($id);

            return redirect()->back()->with('success', '商品刪除成功');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', '商品刪除失敗，請重試');
        }
    }

    // 清除產品相關的快取
    protected function clearProductCache($productId = null)
    {
        if ($productId) {
            Cache::forget('product_' . $productId);
        }

        // 清除所有與產品列表、搜尋和篩選相關的快取
        Cache::flush(); // 這將會清除所有快取
    }
}
