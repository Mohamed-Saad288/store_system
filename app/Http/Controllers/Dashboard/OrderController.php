<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Order\ChangeOrderStatusRequest;
use App\Http\Requests\Dashboard\Order\OrderRequest;
use App\Http\Requests\General\FetchRequest;
use App\Http\Requests\Website\Order\StoreOrderRequest;
use App\Services\Order\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $order_service){}
    public function fetch_orders(FetchRequest $request)
    {
        return $this->order_service->fetch($request);
    }
    public function show_order_details(OrderRequest $request)
    {
        return $this->order_service->show($request);
    }
    public function store_order(StoreOrderRequest $request)
    {
        return $this->order_service->store($request);
    }
//    public function update_order(UpdateOrderRequest $request)
//    {
//        return $this->order_service->update($request);
//    }
    public function delete_order(OrderRequest $request)
    {
        return $this->order_service->delete($request);
    }
    public function change_order_status(ChangeOrderStatusRequest $request)
    {
        return $this->order_service->change_order_status($request);
    }
}
