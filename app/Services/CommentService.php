<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use App\Models\Product;

class CommentService
{
    public function store(Request $request, Product $product)
    {
        // 驗證輸入
        $request->validate([
            'title' => 'required|string',
            'star' => 'required|integer|between:1,5',
            'content' => 'required|string',
        ], [
            'title.required' => '請填寫標題',
            'title.string' => '標題必須是文字',
            'star.required' => '請選擇評分',
            'star.integer' => '評分必須是整數',
            'star.between' => '評分必須在1到5之間',
            'content.required' => '請填寫評論內容',
            'content.string' => '評論內容必須是文字',
        ]);        

        $comment = new Comment([
            'title' => $request->input('title'),
            'star' => $request->input('star'),
            'content' => $request->input('content'),
        ]);

        $comment->product()->associate($product);

        $comment->user()->associate(auth()->user());

        $comment->save();

        return redirect()->route('product.show', $product)->with('success', '評論已成功新增。');
    }

    public function destroy(Product $product, Comment $comment)
    {
        $user = Auth::user();

        if ($comment->user_id !== $user->id) {
            return redirect()->back()->with('error', '您無權刪除該評論');
        }

        $comment->delete();

        return redirect()->route('product.show', $product)->with('success', '評論已成功刪除。');
    }
}