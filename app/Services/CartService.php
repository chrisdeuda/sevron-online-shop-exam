<?php

namespace App\Services;

use Cart;

class CartService
{


    public function getCartContents()
    {
        return Cart::getContent();
    }

    public function addToCart($data)
    {
        // TODO: Make this assignment as DTO for easy processing of data
        $product = [
            'id' => $data['id'],
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
            'attributes' => [
                'photo' => $data['photo'],
            ],
        ];

        Cart::add($product);
    }

    public function getCartItem($id)
    {
       $item = Cart::get($id);

        return $item;
    }

    public function updateCartItem($itemId, $data)
    {
        Cart::update($itemId, $data);
    }

    public function removeCartItem($itemId)
    {
        Cart::remove($itemId);
    }

    public function clearCart()
    {
        Cart::clear();
    }
}
