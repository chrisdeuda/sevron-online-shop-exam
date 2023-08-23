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
        Cart::add($data);
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
