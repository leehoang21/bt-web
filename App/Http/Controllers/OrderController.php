<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOderRequest;
use App\Http\Requests\OderRequest;
use App\Main\Config\AppConst;
use App\Main\Services\OrderService;

class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(
        OrderService $orderService
    )
    {
        $this->service = $orderService;
    }

    public function store(CreateOderRequest $request)
    {
        $order = [
            'id_user' => auth()->user()->id,
            'status' => AppConst::ORDER_STATUS_PENDING,
        ];
        $orderDetail = [
            'id_product' => $request->id_product,
            'quantity' => $request->total,


        ];
        $data = [
            'order' => $order,
            'order_detail' => $orderDetail,
        ];
        return $this->service->save($data);
    }

}
