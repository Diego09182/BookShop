<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;

class CommentController extends Controller
{
    public function index()
    {
        // 顯示所有評論
        $comments = Comment::all();
        return view('comments.index', compact('comments'));
    }

    public function create(Product $product)
    {
        // 顯示新增評論的表單
        return view('comments.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        // 驗證輸入
        $request->validate([
            'title' => 'required|string',
            'star' => 'required|integer|between:1,5',
            'content' => 'required|string',
        ]);

        // 創建評論
        $comment = new Comment([
            'title' => $request->input('title'),
            'star' => $request->input('star'),
            'content' => $request->input('content'),
        ]);

        // 關聯評論和產品
        $comment->product()->associate($product);

        // 關聯評論和當前用戶
        $comment->user()->associate(auth()->user());

        // 儲存評論
        $comment->save();

        return redirect()->route('product.show', $product)->with('success', '評論已成功新增。');
    }

    public function destroy(Product $product, Comment $comment)
    {
        // 刪除評論
        $comment->delete();

        return redirect()->route('product.show', $product)->with('success', '評論已成功刪除。');
    }

}
