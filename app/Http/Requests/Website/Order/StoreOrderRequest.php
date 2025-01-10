<?php

namespace App\Http\Requests\Website\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\ProductStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255","min:4"],
            "phone" => ["required", "string", "max:255"],
            "address" => ["required", "string"],
            "status" => ["nullable", new Enum(OrderStatusEnum::class)],
            "governorate_id" => ["required", "exists:governorates,id"],
            "city" => ["nullable", "string", "max:255"],
            "products"=> ["array", "required"],
            "products.*.id" => ["required", "exists:products,id"],
            "products.*.count" => ["nullable", "integer", "min:1"],
        ];
    }
}
