<?php

namespace App\Services\Product;

use App\Helpers\ImageHelper;
use App\Http\Requests\Dashboard\Product\FetchProductRequest;
use App\Http\Requests\Dashboard\Product\ProductRequest;
use App\Http\Requests\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;
use App\Http\Requests\General\FetchRequest;
use App\Http\Resources\Dashboard\Product\ProductResource;
use App\Models\Product;
use App\Models\ProductDescription;
use App\Models\ProductFeature;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\search;

class ProductService
{
    use ResponseTrait;

    public function fetch(FetchRequest $request)
    {
        $data = $request->validated();
        try {
            $products = Product::search($data)->paginate(15);
            if ($products)
            {
                $message = "تم الوصول لبيانات المنتجات بنجاح";
                return self::dataSuccess(ProductResource::collection($products),$message);
            }else{
                return self::dataFailed("لم يتم الوصول لبيانات المنتج");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    public function show(ProductRequest $request)
    {
        $data = $request->validated();
        try {
            $product = Product::find($data["product_id"]);
            if ($product)
            {
                $message = "تم الوصول لبيانات المنتج بنجاح";
                return self::dataSuccess(new ProductResource($product),$message);

            }else{
                return self::dataFailed("لم يتم الوصول لبيانات المنتج");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();

        try {
            if ($request->hasFile("image")) {
                $data["image"] = ImageHelper::upload($request->file("image"), "products");
            }
            $product = Product::create($data);
            $this->addProductDescriptions($product, $data["product_descriptions"] ?? []);
            $this->addProductFeatures($product, $data["product_features"] ?? []);

            DB::commit();
            return self::dataSuccess(new ProductResource($product), "تم تخزين المنتج بنجاح");
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(["error" => $exception->getMessage()], 500);
        }
    }
    public function update(UpdateProductRequest $request)
    {
        $data = $request->validated();
        DB::beginTransaction();
        $product = Product::find($data["product_id"]);
        try {
            if ($request->hasFile("image")) {
                if ($product->image) {
                    ImageHelper::delete($product->image);
                }
                $data["image"] = ImageHelper::upload($request->file("image"), "products");
            }
            if ($data["code"] !== $product->code) {
                $existingProduct = Product::where('code', $data["code"])->first();
                if ($existingProduct) {
                    return response()->json([
                        'error' => 'The code is already in use by another product.'
                    ], 422);
                }
            }
            $product->update($data);

            $this->updateProductDescriptions($product, $data["product_descriptions"] ?? []);
            $this->updateProductFeatures($product, $data["product_features"] ?? []);

            DB::commit();
            return self::dataSuccess(new ProductResource($product), "تم تحديث المنتج بنجاح");
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(["error" => $exception->getMessage()], 500);
        }
    }
    public function delete(ProductRequest $request)
    {
        $data = $request->validated();
        try {
            $product = Product::find($data["product_id"]);
            $product->delete();
            if ($product)
            {
                $message = "تم حذف النتج بنجاح";
                return self::dataSuccess(new ProductResource($product),$message);

            }else{
                return self::dataFailed("لم يتم حذف المنتج");
            }
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
    private function addProductDescriptions(Product $product, $descriptions)
    {
        foreach ($descriptions as $description) {
            ProductDescription::create([
                "product_id" => $product->id,
                "description" => $description["description"],
            ]);
        }
    }

    private function addProductFeatures(Product $product, array $features)
    {
        foreach ($features as $feature) {
            ProductFeature::create([
                "product_id" => $product->id,
                "feature" => $feature["feature"],
            ]);
        }
    }

    private function updateProductDescriptions(Product $product, array $descriptions)
    {
        $product->product_descriptions()->delete();

        foreach ($descriptions as $description) {
            ProductDescription::create([
                "product_id" => $product->id,
                "description" => $description["description"],
            ]);
        }
    }

    private function updateProductFeatures(Product $product, array $features)
    {
        $product->product_features()->delete();
        foreach ($features as $feature) {
            ProductFeature::create([
                "product_id" => $product->id,
                "feature" => $feature["feature"],
            ]);
        }
    }

}
