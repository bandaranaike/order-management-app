<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Jobs\SendOrderToBeeceptor;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    /**
     * Create new order API
     *
     * @param CreateOrderRequest $request
     * @return JsonResponse
     */
    public function create(CreateOrderRequest $request): JsonResponse
    {

        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->order_value = $request->order_value;
        $order->order_date = now();
        $order->order_status = 'Processing';
        $order->process_id = rand(1, 10);
        $order->save();

        // Dispatch the job to the queue
        SendOrderToBeeceptor::dispatch($order);

        return new JsonResponse(new OrderResource($order));
    }

}
