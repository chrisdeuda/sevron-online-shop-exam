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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $products = (new Product())->newQuery();
        $products->latest();
        $products = $products->paginate(100)->onEachSide(2)->appends(request()->query());

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'can' => [
                'create' => Auth::user()->can('product create'),
                'edit' => Auth::user()->can('product edit'),
                'delete' => Auth::user()->can('product delete'),
            ]
        ]);
    }

    public function store(ProductCreateRequest $request)
    {
        ray("Im here");
        $validatedData = $request->validated();
        $productDTO = new ProductDTO($validatedData);
        $product = $this->productService->createProduct($productDTO);

        return response()->json(['message' => 'Product created successfully', 'product' => $product]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        return response()->json(['product' => $product]);
    }

    public function update(ProductUpdateRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->all();
        $productDTO = new ProductDTO($validatedData);
        $updatedProduct = $this->productService->update($product, $productDTO);

        return response()->json(['message' => 'Product updated successfully', 'product' => $updatedProduct]);
    }


}
