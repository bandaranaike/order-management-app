<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function create(CreateOrderRequest $request): JsonResponse
    {

        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->order_value = $request->order_value;
        $order->order_date = now();
        $order->order_status = 'Processing';
        $order->process_id = rand(1, 10);
        $order->save();

        // Send to the Beeceptor
        $this->sendOrderToBeeceptor($order);

        return new JsonResponse(new OrderResource($order));
    }

    /**
     * Send to third-party API Beeceptor
     * @param Order $order
     * @return void
     */
    private function sendOrderToBeeceptor(Order $order): void
    {
        $beeceptorOrderUrl = Config::get('services.beeceptor_url') . '/order';

        Http::post($beeceptorOrderUrl, [
            'Order_ID' => $order->id,
            'Customer_Name' => $order->customer_name,
            'Order_Value' => $order->order_value,
            'Order_Date' => $order->order_date->format('Y-m-d H:i:s'),
            'Order_Status' => $order->order_status,
            'Process_ID' => $order->process_id,
        ]);
    }
}
