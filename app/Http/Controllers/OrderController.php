<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'order_value' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $order = new Order();
        $order->customer_name = $request->customer_name;
        $order->order_value = $request->order_value;
        $order->order_date = now();
        $order->order_status = 'Processing';
        $order->process_id = rand(1, 10);
        $order->save();

        // Send to third-party API
        $response = Http::post('https://wibip.free.beeceptor.com/order', [
            'Order_ID' => $order->id,
            'Customer_Name' => $order->customer_name,
            'Order_Value' => $order->order_value,
            'Order_Date' => $order->order_date->format('Y-m-d H:i:s'),
            'Order_Status' => $order->order_status,
            'Process_ID' => $order->process_id,
        ]);

        return new OrderResource($order);
    }
}
