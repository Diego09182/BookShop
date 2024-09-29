<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\CartService;
use App\Services\PurchaseService;
use App\Services\EvaluationService;

class ProductController extends Controller
{
    protected $productService;
    protected $cartService;
    protected $purchaseService;
    protected $evaluationService;

    public function __construct(
        ProductService $productService,
        CartService $cartService,
        PurchaseService $purchaseService,
        EvaluationService $evaluationService
    ) {
        $this->productService = $productService;
        $this->cartService = $cartService;
        $this->purchaseService = $purchaseService;
        $this->evaluationService = $evaluationService;
    }

    public function search(Request $request)
    {
        return $this->productService->search($request);
    }

    public function filter(Request $request)
    {
        return $this->productService->filter($request);
    }

    public function showCart()
    {
        return $this->cartService->showCart();
    }

    public function addToCart(Request $request, Product $product)
    {
        return $this->cartService->addToCart($request, $product);
    }

    public function removeFromCart(Product $product)
    {
        return $this->cartService->removeFromCart($product);
    }

    public function purchase()
    {
        return $this->purchaseService->purchase();
    }

    public function like(Product $product)
    {
        return $this->evaluationService->like($product);
    }

    public function dislike(Product $product)
    {
        return $this->evaluationService->dislike($product);
    }

    public function index(Request $request)
    {
        return $this->productService->index($request);
    }

    public function create()
    {
        return $this->productService->create();
    }

    public function store(Request $request)
    {
        return $this->productService->store($request);
    }

    public function show($id)
    {
        return $this->productService->show($id);
    }

    public function edit($id)
    {
        return $this->productService->edit($id);
    }

    public function update(Request $request, $id)
    {
        return $this->productService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->productService->destroy($id);
    }

}
