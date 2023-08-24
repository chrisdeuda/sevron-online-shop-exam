<?php

namespace App\DTO;

class OrderItemDTO
{
    public string $productId;

    public int $quantity;

    public float $price;
    public float $subtotal;

    public function __construct(string $productId, int $quantity, float $price)
    {
        $this->productId = $productId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->subtotal = $quantity * $price;
    }
}
