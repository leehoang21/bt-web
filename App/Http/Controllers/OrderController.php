<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOderRequest;
use App\Main\Config\AppConst;
use App\Main\Services\OrderService;
use Illuminate\Http\Request;

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
        $arrOrder = [];
        $orders = $request->orders;

        for ($i = 0; $i < count($orders); $i++) {
            $orderDetail = [
                'id_product' => $orders[$i]['id_product'],
                'quantity' => $orders[$i]['total'],
            ];
            $arrOrder[$i] = [
                'order' => $order,
                'order_detail' => $orderDetail,
            ];
        }

        $data = [
            'orders' => $arrOrder,

        ];
        return $this->service->save($data);
    }



}
