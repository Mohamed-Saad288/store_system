<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Product\ProductRequest;
use App\Http\Resources\Dashboard\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function fetch_products()
    {
        $products = Product::with("product_descriptions","product_features")->where('status', 1)->latest()->get();
        return response()->json([
            "status" => true,
            "message" => "تم الوصول لباينات المنتجات بنجاح",
            "data" => ProductResource::collection($products)
        ]);
    }
    public function show_product(ProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::with("product_descriptions","product_features")->whereId( $data['product_id'])->first();
        return response()->json(
            [
                "status" => true,
                "message" => "تم الوصول لبيانات المنتج بنجاح",
                "data" => new ProductResource($product)
            ]
        );
    }
}
