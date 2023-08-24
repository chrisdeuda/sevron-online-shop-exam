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

    public function update(Product $product, ProductDTO $productDTO)
    {
        $productData = [
            'name' => $productDTO->name ?? $product->name,
            'price' => $productDTO->price ?? $product->price,
            'description' => $productDTO->description ?? $product->description,
            'photo' => $productDTO->photo ?? $product->photo,
            // Add other properties
        ];

        $product->update($productData);

        return $product;

        $product->update($productData);

        return $product;
    }

}
