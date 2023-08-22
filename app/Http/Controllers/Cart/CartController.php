<?php

namespace App\Http\Controllers\Cart;

use Cart;
//use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();

        return response()->json($cartItems, Response::HTTP_OK);
    }
    public function store(Request $request)
    {
        $data = [
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => [
                'image' => $request->image,
            ],
        ];

        // Validate the data before adding to the cart
        $validator = Validator::make($data, [
            'id' => 'required|integer',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'attributes.image' => 'nullable|string', // Adjust the validation rule as needed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Cart::add($data);

        session()->flash('success', 'Product is Added to Cart Successfully !');

        return response()->json(Cart::getContent(), Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $itemId = $request->id;
        $newQuantity = $request->quantity;

        // Check if the item exists in the cart
        $item = Cart::get($itemId);
        if (!$item) {
            return response()->json(['message' => 'Item not found in the cart.'], Response::HTTP_NOT_FOUND);
        }

        if ($newQuantity <= 0) {
            return response()->json(['message' => 'Quantity must be a positive integer.'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Cart::update(
            $itemId,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $newQuantity,
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return response()->json(Cart::getContent(), Response::HTTP_OK);
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
