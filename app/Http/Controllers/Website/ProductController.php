<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
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
            "message" => "Products retrieved successfully",
            "data" => ProductResource::collection($products)
        ]);
    }
}
