<?php

namespace App\Services;

use App\DTO\OrderDTO;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderProcessor
{
    public function process(OrderDTO $order)
    {
        // Processing logic here
        Log::info('Processing order #' . $order->userId);
    }
}