<?php

namespace App\Jobs;

use App\DTO\OrderDTO;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Services\OrderProcessor;
class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public OrderDTO $order;
    /**
     * Create a new job instance.
     */
    public function __construct(OrderDTO $order)
    {
        Log::info('Job received');
        $this->order = $order;
    }

    public function handle(OrderProcessor $orderProcessor)
    {
        $orderProcessor->process($this->order);
    }
}
