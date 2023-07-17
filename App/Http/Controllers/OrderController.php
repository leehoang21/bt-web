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
        $products = $request->products;
        $arrOrder = [];
        for ($i = 0; $i < count($products); $i++) {
            $orderDetail = [
                'id_product' => $products[$i],
                'quantity' => $request->array_total[$i],
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
