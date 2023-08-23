<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderCheckoutProcessorService
{
    public function processOrderCheckout($user, $requestData)
    {
        return DB::transaction(function () use ($user, $requestData) {

            // Create a new order
            $order = new Order();
            $order->user_id = $user->id;
            $order->total_amount = $requestData['total_amount'];
            $order->order_status = 'pending';
            $order->save();

            // Loop through the items and create order items
            foreach ($requestData['items'] as $item) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $item['id'];
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $item['price'];
                $orderItem->subtotal = $item['quantity'] * $item['price'];
                // Save additional attributes if needed
                $orderItem->save();
            }

            // Clean the cart after successful order processing

            return $order;
        });
    }
}
