<?php

namespace App\Http\Resources\Dashboard\Order;

use App\Enums\ProductStatusEnum;
use App\Http\Resources\Dashboard\Governorate\GovernorateOrderResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rules\Enum;

class OrderDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           "name" => $this->name,
            "phone" => $this->phone,
            "city" => $this->city,
            "address" => $this->address,
            "governorate" => new GovernorateOrderResource($this->governorate ?? null ) ?? null
        ];
    }
}
