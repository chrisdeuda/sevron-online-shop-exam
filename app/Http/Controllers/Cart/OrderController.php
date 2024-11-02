<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\OrderCheckoutCreateRequest;
use App\Services\OrderCheckoutProcessorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected OrderCheckoutProcessorService $orderCheckoutProcessorService;

    /**
     * OrderController constructor.
     * 
     * @param OrderCheckoutProcessorService $orderCheckoutProcessor
     */
    public function __construct(OrderCheckoutProcessorService $orderCheckoutProcessor)
    {
        $this->orderCheckoutProcessorService = $orderCheckoutProcessor;
        $this->middleware('auth');
    }

    /**
     * Checkout the order.
     * 
     * @param OrderCheckoutCreateRequest $request
     * @return JsonResponse
     */
    public function checkout(OrderCheckoutCreateRequest $request): JsonResponse
    {
        $user = Auth::user();

        $requestData = $request->validated();

        $order = $this->orderCheckoutProcessorService->processOrderCheckout($user, $requestData);

        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }
}

