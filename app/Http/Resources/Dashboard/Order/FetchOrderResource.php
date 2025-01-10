<?php

namespace App\Http\Resources\Dashboard\Order;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules\Enum;

class FetchOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Set the locale to Arabic
        Carbon::setLocale('ar');

        return [
            "code" => $this->code,
            "status" => $this->status,
            "OrderDetails" => [
                "client_name" => $this->order_details->name ?? null,
                "client_phone" => $this->order_details->phone ?? null,
            ],
            "created_at" => $this->created_at->diffForHumans()
        ];
    }
}
