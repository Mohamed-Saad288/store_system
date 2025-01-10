<?php

namespace App\Http\Resources\Dashboard\Statistics;

use App\Enums\OrderStatusEnum;
use App\Http\Resources\Dashboard\Order\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class StatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $today = Carbon::now('Africa/Cairo')->toDateString();
        $todayOrdersCount = Order::whereDate('created_at', $today)->count();
        $totalOrdersCount = Order::count();

        return [
            "today_orders" => $todayOrdersCount,
            "total_orders" => $totalOrdersCount,
            "today_complete_orders" => $this->countOrdersByStatus(OrderStatusEnum::Done, $today),
            "total_complete_orders" => $this->countOrdersByStatus(OrderStatusEnum::Done),
            "today_canceled_orders" => $this->countOrdersByStatus(OrderStatusEnum::Rejected, $today),
            "total_canceled_orders" => $this->countOrdersByStatus(OrderStatusEnum::Rejected),
            "today_pending_orders" => $this->countOrdersByStatus(OrderStatusEnum::Pending, $today),
            "total_pending_orders" => $this->countOrdersByStatus(OrderStatusEnum::Pending),
        ];
    }

    private function countOrdersByStatus(OrderStatusEnum $status, ?string $date = null): int
    {
        $query = Order::whereStatus($status->value);
        if ($date) {
            $query->whereDate('created_at', $date);
        }
        return $query->count();
    }
}
