<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(Request $request, Product $product)
    {
        return $this->commentService->store($request, $product);
    }

    public function destroy(Product $product, Comment $comment)
    {
        return $this->commentService->destroy($product, $comment);
    }

}
