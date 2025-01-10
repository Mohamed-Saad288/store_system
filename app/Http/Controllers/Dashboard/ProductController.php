<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Product\FetchProductRequest;
use App\Http\Requests\Dashboard\Product\ProductRequest;
use App\Http\Requests\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;
use App\Http\Requests\General\FetchRequest;
use App\Services\Product\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $product_service){}
    public function fetch_products(FetchRequest $request)
    {
        return $this->product_service->fetch($request);
    }
    public function show_product(ProductRequest $request)
    {
        return $this->product_service->show($request);
    }
    public function store_product(StoreProductRequest $request)
    {
        return $this->product_service->store($request);
    }
    public function update_product(UpdateProductRequest $request)
    {
        return $this->product_service->update($request);
    }
    public function delete_product(ProductRequest $request)
    {
        return $this->product_service->delete($request);
    }
}
