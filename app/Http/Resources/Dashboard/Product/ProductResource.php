<?php

namespace App\Http\Resources\Dashboard\Product;

use App\Enums\ProductStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rules\Enum;

class ProductResource extends JsonResource
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
           "name" => $this->name ?? null,
            "section" => $this->section ?? null,
            "price_before_discount" => $this->price_before_discount ?? null,
            "price_after_discount" => $this->price_after_discount ?? null,
            "code" => $this->code ?? null,
            "image" => $this->imageLink ?? null,
            "status" => $this->status ?? null,
            "product_descriptions" => ProductDescriptionResource::collection($this->product_descriptions ?? []) ?? [],
            "product_features" => ProductFeatureResource::collection($this->product_features ?? []) ?? []
        ];
    }
}
