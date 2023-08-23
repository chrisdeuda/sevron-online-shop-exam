<?php

namespace App\Http\Controllers\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\OrderCheckoutCreateRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderCheckoutProcessorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    protected OrderCheckoutProcessorService $orderCheckoutProcessor;

    public function __construct(OrderCheckoutProcessorService $orderCheckoutProcessor)
    {
        $this->orderCheckoutProcessor = $orderCheckoutProcessor;
    }

    public function checkout(OrderCheckoutCreateRequest $request)
    {
        $user = Auth::user();

        $requestData = $request->validated();

        $order = $this->orderCheckoutProcessor->processOrderCheckout($user, $requestData);

        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }
}
