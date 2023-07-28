<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOderRequest;
use App\Main\Config\AppConst;
use App\Main\Services\OrderService;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class OrderController extends Controller
{
    protected OrderService $service;

    public function __construct(
        OrderService $orderService
    )
    {
        $this->service = $orderService;
    }

    public function index(Request $request)
    {
        $page = (int)$request->page;
        $data = [
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,

            'keyword' => $request->keyword,
            'search_fields' => $request['search_fields']
        ];
        return $this->service->getAll($data);
    }

    public function store(CreateOderRequest $request)
    {

        $order = [
            'id_user' => isEmpty(auth()->user()) ? -1 : auth()->user()->id,
            'status' => AppConst::ORDER_STATUS_PENDING,
            'address' => $request->address,
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
