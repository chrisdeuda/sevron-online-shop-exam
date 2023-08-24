<?php

namespace App\Services\Admin\Product;

use App\DTO\ProductDTO;
use App\Models\Product;

class ProductService
{
    public function createProduct(ProductDTO $productDTO)
    {
        $productData = [
            'name' => $productDTO->name,
            'price' => $productDTO->price,
            // Add other properties
        ];

        return Product::create($productData);
    }

}
