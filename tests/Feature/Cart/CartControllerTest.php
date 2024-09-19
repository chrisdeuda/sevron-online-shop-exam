<?php

namespace Tests\Feature\Cart;

use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;
use Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    // Index action tests
    public function testCartIndex()
    {
        Cart::add(['id' => 1, 'name' => 'Product 1', 'price' => 10, 'quantity' => 2]);
        Cart::add(['id' => 2, 'name' => 'Product 2', 'price' => 20, 'quantity' => 1]);

        $response = $this->get(route('api.cart.index'));

        $response->assertStatus(200)
            ->assertJsonCount(2);
    }

    public function testCartIndexEmptyCart()
    {

        $response = $this->delete(route('cart.clear'));

        $response->assertStatus(204);

    }

    // Store action tests
    public function testCartStore()
    {
        $data = [
            'id' => Str::uuid()->toString(),
            'name' => 'Product 1',
            'price' => 10,
            'quantity' => 2,
            'photo' =>  'product1.jpg'
        ];

        $response = $this->post(route('cart.store'), $data);

        $response->assertStatus(200)
            ->assertJsonCount(1);
    }

    public function testCartStoreInvalidData()
    {
        $invalidData = [
            'id' => Str::uuid()->toString(),
            'name' => 'Product 1',
            'price' => 10,
            'quantity' => 0, // Invalid quantity value
        ];

        $this->withoutExceptionHandling(); // This allows exceptions to be thrown and not caught

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('The quantity field must be at least 1.');

        $this->post(route('cart.store'), $invalidData);
    }


    // Update action tests
    public function testCartUpdate()
    {
        Cart::add(['id' => 1, 'name' => 'Product 1', 'price' => 10, 'quantity' => 2]);

        $data = [
            'quantity' => 5,
        ];

        $response = $this->post(route('cart.update', 1), $data);

        $response->assertStatus(200)
            ->assertJsonFragment(['quantity' => 7]);
    }


    public function testCartUpdateNonExistingItem()
    {
        $data = [
            'id' => 999, // Non-existing item ID
            'quantity' => 5,
        ];

        $response = $this->post(route('cart.update', 999), $data);

        $response->assertStatus(404);
    }

    // Destroy action tests
    public function testCartDestroy()
    {
        Cart::add(['id' => 1, 'name' => 'Product 1', 'price' => 10, 'quantity' => 2]);

        $response = $this->delete(route('cart.destroy', 1));

        $response->assertStatus(200)
            ->assertJsonCount(0);
    }

    public function testCartDestroyNonExistingItem()
    {
        $response = $this->delete(route('cart.destroy', 999));

        $response->assertStatus(404);
    }

    // Clear action tests
    public function testCartClear()
    {
        Cart::add(['id' => 1, 'name' => 'Product 1', 'price' => 10, 'quantity' => 2]);
        Cart::add(['id' => 2, 'name' => 'Product 2', 'price' => 20, 'quantity' => 1]);

        $response = $this->delete(route('cart.clear'));

        $response->assertStatus(204);

    }

    public function testCartClearEmptyCart()
    {
        Cart::clear();

        $response = $this->delete(route('cart.clear'));

        $response->assertStatus(204);

    }
}
