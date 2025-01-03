<?php

namespace App\Http\Resources\Dashboard\Setting;

use App\Http\Resources\Dashboard\Governorate\GovernorateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
           "delivery" => $this->delivery ?? null,
            "governorate" => new GovernorateResource($this->governorate ?? null) ?? null
        ];
    }
}
