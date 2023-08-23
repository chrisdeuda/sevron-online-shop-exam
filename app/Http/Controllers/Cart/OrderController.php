<?php

namespace App\Http\Controllers\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            // Define validation rules here
        ]);

        ray($request->all());

        // Create a new order
        $order = new Order();
        $order->user_id = $user->id;
        $order->total_amount = $request->input('total_amount');
        $order->order_status = 'pending'; // You can set the initial status
        $order->save();

        // Loop through the items and create order items
        foreach ($request->input('items') as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['product_id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['price'];
            $orderItem->subtotal = $item['quantity'] * $item['price'];
            $orderItem->save();
        }

        return response()->json(['message' => 'Order placed successfully']);
    }
}
