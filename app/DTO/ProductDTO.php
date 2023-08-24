<?php

namespace App\DTO;

class ProductDTO
{
    public string $name;

    public float $price;

    public ?string $description;

    public ?string $photo;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->description = $data['description'] ?? null;
        $this->photo = $data['photo'] ?? null;     }
}
