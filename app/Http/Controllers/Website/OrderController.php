<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\Order\StoreOrderRequest;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $orderService){}
    public function store_order(StoreOrderRequest $request)
    {
        return $this->orderService->store($request);
    }
}
