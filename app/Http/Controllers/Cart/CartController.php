<?php

namespace App\Http\Controllers\Cart;

use App\Services\CartService;
use Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class CartController extends Controller
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
    public function store(CartCreateRequest $request)
    {
        $data = $request->validated();

        ray($data);

        $this->cartService->addToCart($data);

        ray($this->cartService->getCartContents());
        return response()->json($this->cartService->getCartContents(), Response::HTTP_OK);
    }

    public function update(CartUpdateRequest $request, $id)
    {
        $data = $request->validated();

        if (!$this->cartService->getCartItem($id)) {
            return response()->json(['error' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        $this->cartService->updateCartItem($id, ['quantity' => $data['quantity']]);

        return response()->json([
            'message' => 'Item Cart is Updated Successfully!',
            'carts' => $this->cartService->getCartContents(),
        ], Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $itemId = $request->id;

        if (!$this->cartService->getCartItem($itemId)) {
            return response()->json(['error' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        $this->cartService->removeCartItem($itemId);

        return response()->json($this->cartService->getCartContents(), Response::HTTP_OK);
    }
    public function clear()
    {
        $this->cartService->clearCart();

        return response()->json($this->cartService->getCartContents(), Response::HTTP_NO_CONTENT);
    }

    public function total(){
        // TODO: Fix returning of total count
        return response()->json(['total' => Cart::count()]);
    }
}
