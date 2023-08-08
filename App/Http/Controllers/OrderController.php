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
        $idUser = auth()->user()->id;

        $searchFields = $request['search_fields'].',id_user';
        $keyword = $request->keyword.','.$idUser;

        $data = [
            'page' => !empty($page) ? abs($page) : 1,
            'limit' => !empty($request->limit) ? (int)$request->limit : AppConst::PAGE_LIMIT,
            'keyword' => $keyword,
            'search_fields' => $searchFields,
        ];
        return $this->service->getAll($data);
    }

    public function store(CreateOderRequest $request)
    {
        $order = [
            'id_user' =>  auth()->user()->id,
            'status' => AppConst::ORDER_STATUS_PENDING,
            'id_address' => $request->id_address,
        ];
        $arrOrder = [];
        foreach ($request->orders as $key => $value) {
           $order[$key] = $value;
        }
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
