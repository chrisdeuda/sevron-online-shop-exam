<?php

namespace Tests\Feature\Cart;

use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\Cart\OrderCheckoutCreateRequest;
use App\Services\OrderCheckoutProcessorService;
use App\Models\User;
use App\Models\Order;
use Database\Factories\OrderFactory;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function testSuccessfulOrderCheckout()
    {
        // Create a user using the UserFactory
        $user = User::factory()->create();

        // Create an order using the OrderFactory
        $order = Order::factory()->create([
            'user_id' => $user->id, // Assign the user to the order
        ]);

        // Mock the OrderCheckoutProcessorService to return the order
        $mockService = $this->mock(OrderCheckoutProcessorService::class);
        $mockService->shouldReceive('processOrderCheckout')->andReturn($order);
        $this->app->instance(OrderCheckoutProcessorService::class, $mockService);

        // Simulate request data
        $requestData = [
            'total_amount' => $this->faker->randomFloat(2, 10, 100),
            'items' => [
                // Mock order items data here
            ],
        ];

        // Mock the validation result for the request
        $this->instance(OrderCheckoutCreateRequest::class, Mockery::mock(OrderCheckoutCreateRequest::class, function ($mock) use ($requestData) {
            $mock->shouldReceive('validated')->andReturn($requestData);
        }));

        // Act: Call the checkout method on the controller
        $response = $this->actingAs($user)
            ->postJson(route('order.checkout'));

        // Assert the response
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Order placed successfully',
                'order' => $order->toArray(),
            ]);
    }

    public function testFailedOrderProcessing()
    {
        $user = User::factory()->create();

        // Mock the OrderCheckoutProcessorService to return null (failure)
        $mockService = $this->mock(OrderCheckoutProcessorService::class);
        $mockService->shouldReceive('processOrderCheckout')->andReturn(null);
        $this->app->instance(OrderCheckoutProcessorService::class, $mockService);

        // Create mock request data
        $requestData = [
            'total_amount' => $this->faker->randomFloat(2, 10, 100), // Adjust as needed
            'items' => [

            ],
        ];

        // Act: Call the checkout method on the controller
        $response = $this->actingAs($user)
            ->postJson(route('order.checkout'), $requestData); // Pass request data directly

        // Assert the response
        $response->assertStatus(422) // Internal server error status
        ->assertJson([
          //  'message' => 'Failed to process order',
            'errors' => [
                'name' => ['The name field is required.'],
                'email' => ['The email field is required.'],
                'items' => ['The items field is required.'],
            ],
        ]);
    }

    // Similar tests for other scenarios...

    public function testUnauthenticatedAccess()
    {
        $response = $this->postJson(route('order.checkout'));

        $response->assertStatus(401);
    }

}

