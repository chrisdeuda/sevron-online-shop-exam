<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:product list', ['only' => ['index', 'show']]);
        $this->middleware('can:product create', ['only' => ['create', 'store']]);
        $this->middleware('can:product edit', ['only' => ['edit', 'update']]);
        $this->middleware('can:product delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = (new Product())->newQuery();
        $products->latest();
        $products = $products->paginate(100)->onEachSide(2)->appends(request()->query());

        ray($products);

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
            'can' => [
                'create' => Auth::user()->can('product create'),
                'edit' => Auth::user()->can('product edit'),
                'delete' => Auth::user()->can('product delete'),
            ]
        ]);
    }
}
