<?php

namespace App\Services\Order;

use App\Http\Requests\Website\Order\StoreOrderRequest;
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
            // Create the order with default total values
            $order = Order::create([
                'total' => 0,
                'total_before_delivery' => 0,
            ]);

            // Create order details
            $orderDetails = OrderDetails::create([
                "order_id" => $order->id,
                "name" => $data["name"],
                "phone" => $data["phone"],
                "governorate_id" => $data["governorate_id"],
                "city" => $data["city"],
                "address" => $data["address"],
            ]);

            // Fetch delivery fee from the governorate
            $delivery = Governorate::findOrFail($orderDetails->governorate_id);

            // Fetch product details
            $productIds = collect($data['products'])->pluck('id');
            $products = Product::whereIn('id', $productIds)->get();

            // Initialize the total before delivery
            $totalBeforeDelivery = 0;

            // Process products and calculate total
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

            // Calculate final total including delivery fee
            $totalPrice = $totalBeforeDelivery + $delivery->price;

            // Update order with final totals
            $order->update([
                'total' => $totalPrice,
                'total_before_delivery' => $totalBeforeDelivery,
            ]);

            DB::commit();

            // Return success response
            return response()->json([
                "status" => true,
                'message' => 'Order created successfully!',
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

}
