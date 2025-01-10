<?php

namespace App\Services\Order;

use App\Http\Requests\Dashboard\Order\OrderRequest;
use App\Http\Requests\General\FetchRequest;
use App\Http\Requests\Website\Order\StoreOrderRequest;
use App\Http\Resources\Dashboard\Order\FetchOrderResource;
use App\Http\Resources\Dashboard\Order\OrderResource;
use App\Models\Governorate;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function store(StoreOrderRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();

        try {
            $order = Order::create([
                'total' => 0,
                'total_before_delivery' => 0,
            ]);

            $orderDetails = OrderDetails::create([
                "order_id" => $order->id,
                "name" => $data["name"],
                "phone" => $data["phone"],
                "governorate_id" => $data["governorate_id"],
                "city" => $data["city"],
                "address" => $data["address"],
            ]);

            $delivery = Governorate::findOrFail($orderDetails->governorate_id);

            $productIds = collect($data['products'])->pluck('id');
            $products = Product::whereIn('id', $productIds)->get();

            $totalBeforeDelivery = 0;

            foreach ($data["products"] as $productData) {
                $product = $products->firstWhere('id', $productData['id']);
                if (!$product) {
                    throw new \Exception('Invalid product ID: ' . $productData['id']);
                }

                $productTotal = $productData["count"] * $product->price_after_discount;
                $totalBeforeDelivery += $productTotal;

                // Create order-product entry
                OrderProduct::create([
                    "order_id" => $order->id,
                    "product_id" => $productData["id"],
                    "count" => $productData["count"],
                    "price" => $product->price_after_discount,
                ]);
            }

            $totalPrice = $totalBeforeDelivery + $delivery->price;

            $order->update([
                'total' => $totalPrice,
                'total_before_delivery' => $totalBeforeDelivery,
            ]);

            DB::commit();

            // Return success response
            return response()->json([
                "status" => true,
                'message' => "تم انشاء الطلب بنجاح",
                'data' => new OrderResource($order),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            // Return failure response
            return response()->json([
                'status' => false,
                'error' => 'Failed to create order',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
    public function show(OrderRequest $request)
    {
        $data = $request->validated();
        $order = Order::findOrFail($data["order_id"])->load('products',"order_details","order_products");
        return response()->json([
            "status" => true,
            "message" => "تم الوصول لبانات الطلب بنجاح",
            "data" => new OrderResource($order),
        ]);

    }
    public function fetch(FetchRequest $request)
    {
        $order = Order::with("order_details:name,phone")->latest()->paginate(15);
        return response()->json([
            "status" => true,
            "message" => "تم الوصول لببانات الطلبات بنجاح",
            "data" => FetchOrderResource::collection($order)
        ]);
    }
    public function delete(OrderRequest $request)
    {
        $data = $request->validated();
        $order = Order::findOrFail($data["order_id"]);
        $order->delete();

        return response()->json([
            "status" => true,
            "message" => "تم حذف الطلب بنجاح",
            "data" => new FetchOrderResource($order)
        ]);
    }

}
