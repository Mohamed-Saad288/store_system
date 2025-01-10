<?php

namespace App\Http\Resources\Dashboard\Product;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rules\Enum;

class ProductFeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
           "id" => $this->id,
            "feature" => $this->feature ?? null
        ];
    }
}
