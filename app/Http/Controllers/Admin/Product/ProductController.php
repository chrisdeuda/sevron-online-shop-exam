<?php

namespace App\Http\Controllers\Admin\Product;

use App\DTO\ProductDTO;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\Admin\Product\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->middleware('can:product list', ['only' => ['index', 'show']]);
        $this->middleware('can:product create', ['only' => ['create', 'store']]);
        $this->middleware('can:product edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:product delete', ['only' => ['destroy']]);

        $this->productService = $productService;
    }

    public function store(ProductCreateRequest $request)
    {
       
        $productDTO = new ProductDTO($request->validated());
        $product = $this->productService->createProduct($productDTO);

        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['product' => $product]);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $productDTO = new ProductDTO($request->all());
        $updatedProduct = $this->productService->update($product, $productDTO);

        return response()->json(['message' => 'Product updated successfully', 'product' => $updatedProduct]);
    }
    
}

