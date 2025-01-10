<?php

namespace App\Http\Resources\Dashboard\Order;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rules\Enum;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "code" => $this->code,
            "total_before_delivery" => $this->total_before_delivery,
            "total" => $this->total,
            "OrderDetails" => new OrderDetailsResource($this->order_details ?? null) ?? null,
            "orderProducts" => OrderProductResource::collection($this->order_products ?? []) ?? null,
        ];
    }
}
