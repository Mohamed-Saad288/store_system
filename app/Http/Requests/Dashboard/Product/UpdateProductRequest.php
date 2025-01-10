<?php

namespace App\Http\Requests\Dashboard\Product;

use App\Enums\ProductStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateProductRequest extends FormRequest
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
            "product_id" => "required|exists:products,id",
            "name" => "required|string|max:255",
            "image" => "nullable|image",
            "price_after_discount" => "required|numeric",
            "price_before_discount" => "nullable|numeric",
            "section" => "nullable|string|max:255",
            "status" => ["nullable",new Enum(ProductStatusEnum::class)],
            "code" => "nullable|string|max:255",
            "product_descriptions" => "nullable|array",
            "product_descriptions.*.description" => "nullable|string",
            "product_features" => "nullable|array",
            "product_descriptions.*.feature" => "nullable|string",
        ];
    }
}
