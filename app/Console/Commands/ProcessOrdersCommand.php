<?php

namespace App\Console\Commands;

use App\DTO\OrderDTO;
use Illuminate\Console\Command;
use App\Models\Order;
use App\Jobs\ProcessOrderJob;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class ProcessOrdersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $order = new OrderDTO(
            1,
            1,
            'pending',
            
        );
        Log::info('Order Received');

        Log::info('Order Received');
        // Call the OrderService JOb
        Bus::chain([
            new ProcessOrderJob($order),
//            new ProcessOrderJob($orders),
//            new ProcessOrderJob($orders),
            // Add more jobs as needed
        ])->dispatch();
    }
}
