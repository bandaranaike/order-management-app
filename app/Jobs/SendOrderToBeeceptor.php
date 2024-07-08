<?php

namespace App\Jobs;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendOrderToBeeceptor implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     * Send to third-party API Beeceptor
     */
    public function handle(): void
    {
        $beeceptorOrderUrl = Config::get('services.beeceptor_url') . '/order';

        Http::post($beeceptorOrderUrl, [
            'Order_ID' => $this->order->id,
            'Customer_Name' => $this->order->customer_name,
            'Order_Value' => $this->order->order_value,
            'Order_Date' => $this->order->order_date->format('Y-m-d H:i:s'),
            'Order_Status' => $this->order->order_status,
            'Process_ID' => $this->order->process_id,
        ]);
    }
}
