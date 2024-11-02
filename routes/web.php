<?php

use App\Http\Controllers\Admin\Order\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\Product\ProductController as AdminProductController;
use App\Http\Controllers\Admin\Product\ProductPageController as AdminProductPageController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\CartPageController;
use App\Http\Controllers\Cart\OrderController;
use App\Http\Controllers\Guest\Product\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/products', [ProductController::class, 'index']);

require __DIR__.'/auth.php';

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin',
    'middleware' => ['auth'],
], function () {
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');
    Route::resource('permission', 'PermissionController');
    Route::resource('product', 'ProductController');

    Route::get('product', [AdminProductPageController::class, 'index'])->name('admin.product.index');
});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'api/admin',
    'middleware' => ['auth'],
], function () {
    Route::post('product', [AdminProductController::class, 'store'])->name('admin.product.store');
    Route::post('product/{id}', [AdminProductController::class, 'update'])->name('admin.product.update');

    Route::get('orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
});



Route::get('products', [ProductController::class, 'index'])->name('products.list');

// Pages
Route::get('cart', [CartPageController::class, 'index'])->name('cart.index');

Route::get('cart', [CartController::class, 'index'])->name('api.cart.index');
Route::get('cart/total', [CartController::class, 'index'])->name('cart.total');
Route::post('cart', [CartController::class, 'store'])->name('cart.store');
Route::post('cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::delete('cart', [CartController::class, 'clear'])->name('cart.clear');


Route::middleware('auth')->group(function () {
    Route::post('api/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
});

Route::get('/vapor-ui-test', function () {
    if (Gate::allows('viewVaporUI')) {
        return 'Vapor UI should be accessible';
    }
    return 'Vapor UI access denied';
});


Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'shop',
    'middleware' => ['auth'],
], function () {

    Route::get('product', [\App\Http\Controllers\Guest\Product\ProductController::class, 'index'])->name('shop.index');

});
