<?php

namespace App\Http\Resources\Dashboard\Order;

use App\Http\Resources\Dashboard\Product\ProductResource;
use App\Http\Resources\Dashboard\Product\SimpleProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            "product" => new SimpleProductResource($this->product ?? null),
            "count" => $this->count,
            "price" => $this->price,
        ];
    }
}
