<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Evaluation;

class EvaluationService
{
    public function like(Product $product)
    {
        return $this->evaluate($product, 1, 'like', '您已成功喜歡該產品。');
    }

    public function dislike(Product $product)
    {
        return $this->evaluate($product, -1, 'dislike', '您已成功不喜歡該產品。');
    }

    private function evaluate(Product $product, int $evaluationValue, string $counter, string $successMessage)
    {
        $user = Auth::user();

        $evaluation = Evaluation::where('product_id', $product->id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($evaluation) {
            return back()->with('success', '您已經對該產品進行了評價。');
        }

        Evaluation::create([
            'product_id' => $product->id,
            'user_id' => $user->id,
            'evaluation' => $evaluationValue,
        ]);

        $product->increment($counter);

        return back()->with('success', $successMessage);
    }
}
