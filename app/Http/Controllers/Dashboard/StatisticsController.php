<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\Statistics\StatisticsResource;
use App\Models\Order;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function fetch_statistics()
    {
        $statistics = new StatisticsResource(Order::class);

        return response()->json([
            "status" => true,
            "message" => "success",
            "data" => $statistics,
        ]);
    }
}
