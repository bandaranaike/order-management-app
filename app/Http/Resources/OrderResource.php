<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'Order_ID' => $this->id,
            'Process_ID' => $this->process_id,
            'Status' => $this->order_status,
        ];
    }
}
