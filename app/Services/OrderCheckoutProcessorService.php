<?php
namespace App\Services;

use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderCheckoutProcessorService
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Process the order checkout.
     *
     * @param mixed $user
     * @param array $requestData
     * @return Order
     */
    public function processOrderCheckout(User $user, array $requestData)
    {
        return DB::transaction(function () use ($user, $requestData) {
            // Create an OrderDTO to encapsulate order data
            $orderDTO = new OrderDTO(
                $user->id,
                $requestData['total_amount'],
                'pending'
            );

            // Create the order with the provided data
            $order = $this->createOrder($orderDTO);

            // Create and associate order items with the order
            $this->createOrderItems($order, $requestData['items']);

            // Clear the user's cart after successful checkout
            $this->cartService->clearCart();

            return $order;
        });
    }

    /**
     * Create an Order model based on the provided OrderDTO.
     *
     * @param OrderDTO $orderDTO
     * @return Order
     */
    protected function createOrder(OrderDTO $orderDTO): Order
    {
        // Create a new Order instance and populate its properties
        $order = new Order([
            'user_id' => $orderDTO->userId,
            'total_amount' => $orderDTO->totalAmount,
            'order_status' => $orderDTO->orderStatus,
        ]);

        // Save the order to the database
        $order->save();

        return $order;
    }

    /**
     * Create and associate OrderItem models with the provided Order.
     *
     * @param Order $order
     * @param array $items
     * @return void
     */
    protected function createOrderItems(Order $order, array $items): void
    {
        foreach ($items as $itemData) {
            // Create an OrderItemDTO to encapsulate item data
            $orderItemDTO = $this->createOrderItemDTO($itemData);

            // Create an OrderItem model and associate it with the order
            $orderItem = $this->createOrderItem($order, $orderItemDTO);

            // Save the order item to the database
            $orderItem->save();
        }
    }

    /**
     * Create an OrderItemDTO based on the provided item data.
     *
     * @param array $itemData
     * @return OrderItemDTO
     */
    protected function createOrderItemDTO(array $itemData): OrderItemDTO
    {
        // Create a new OrderItemDTO instance and populate its properties
        return new OrderItemDTO(
            $itemData['id'],
            $itemData['quantity'],
            $itemData['price']
        );
    }

    /**
     * Create an OrderItem model based on the provided OrderItemDTO.
     *
     * @param Order $order
     * @param OrderItemDTO $orderItemDTO
     * @return OrderItem
     */
    protected function createOrderItem(Order $order, OrderItemDTO $orderItemDTO): OrderItem
    {
        // Create a new OrderItem instance and populate its properties
       return  new OrderItem([
            'order_id' => $order->id,
            'product_id' => $orderItemDTO->productId,
            'quantity' => $orderItemDTO->quantity,
            'price' => $orderItemDTO->price,
            'subtotal' => $orderItemDTO->subtotal,
        ]);
    }
}
