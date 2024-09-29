<?php

namespace App\Http\Controllers;

use App\Services\OrderService;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getOrders();
        return view('Shop.orders', compact('orders'));
    }

    public function update($id)
    {
        $this->orderService->markOrderAsShipped($id);
        return redirect()->route('management.orders')->with('success', '訂單已標記為已出貨');
    }
}
