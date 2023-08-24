<?php

namespace App\DTO;

class ProductDTO
{
    public string $name;
    public float $price;
    // Add more properties as needed

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->price = $data['price'];
        // Initialize other properties
    }
}
