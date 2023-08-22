<?php

namespace App\Http\Controllers\Cart;

use Cart;
//use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::getContent();

        return response()->json($cartItems, Response::HTTP_OK);
    }
    public function store(Request $request)
    {
        Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);

        session()->flash('success', 'Product is Added to Cart Successfully !');

        return response()->json( Cart::getContent(), Response::HTTP_OK);
    }
    public function update(Request $request)
    {
        Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );
        session()->flash('success', 'Item Cart is Updated Successfully !');
        return response()->json( Cart::getContent(), Response::HTTP_OK);
    }
    public function destroy(Request $request)
    {
        Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');
        return response()->json( Cart::getContent(), Response::HTTP_OK);
    }
    public function clear()
    {
        Cart::clear();
        session()->flash('success', 'All Item Cart Clear Successfully !');
        return response()->json( Cart::getContent(), Response::HTTP_OK);
    }
}
