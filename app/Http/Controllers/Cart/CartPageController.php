<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\CartService;
use Inertia\Inertia;

class CartPageController extends Controller
{

    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        //TODO: add paginations
        $cartItems = $this->cartService->getCartContents();

        return Inertia::render('Shop/Product/Cart', [
            'cartItems' => $cartItems,
        ]);
    }

}
