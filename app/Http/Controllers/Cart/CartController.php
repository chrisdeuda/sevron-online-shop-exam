<?php

namespace App\Http\Controllers\Cart;

use App\Services\CartService;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService,
        )
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = Cart::getContent();

        return response()->json($cartItems, Response::HTTP_OK);
    }
    public function store(CartCreateRequest $request)
    {
        $data = $request->validated();

        $this->cartService->addToCart($data);

        session()->flash('success', 'Product is Added to Cart Successfully !');

        return response()->json(Cart::getContent(), Response::HTTP_OK);
    }

    public function update(CartUpdateRequest $request, $id)
    {

        $data = $request->validated();


        // Check if the item exists in the cart
        $item = $this->cartService->getCartItem($id);
        if (!$item) {
            return response()->json(['message' => 'Item not found in the cart.'], Response::HTTP_NOT_FOUND);
            return response()->json(['error' => 'Item not found'], Response::HTTP_NOT_FOUND);
        }

        // Update the item's quantity
        $this->cartService->updateCartItem($id, ['quantity' => $data['quantity']]);
        session()->flash('success', 'Item Cart is Updated Successfully !');

        // Return the updated cart contents
        return response()->json($this->cartService->getCartContents(), Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $itemId = $request->id;

        // Check if the item exists in the cart
        $item = Cart::get($itemId);
        if (!$item) {
            return response()->json(['message' => 'Item not found in the cart.'], Response::HTTP_NOT_FOUND);
        }

        Cart::remove($itemId);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return response()->json(Cart::getContent(), Response::HTTP_OK);
    }
    public function clear()
    {
        Cart::clear();
        session()->flash('success', 'All Item Cart Clear Successfully !');
        return response()->json( Cart::getContent(), Response::HTTP_OK);
    }
}
