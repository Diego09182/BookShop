<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public function getOrders()
    {
        return Order::paginate(8);
    }

    public function markOrderAsShipped($id)
    {
        $order = Order::findOrFail($id);
        $order->status = '已出貨';
        $order->save();
        return $order;
    }
}

