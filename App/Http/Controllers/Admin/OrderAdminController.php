<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOderRequest;
use App\Http\Requests\OderRequest;
use App\Main\Config\AppConst;
use App\Main\Services\OrderService;
use Illuminate\Http\Request;;

class OrderAdminController extends Controller
{
    protected OrderService $service;
    private $arr;

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

//        $order = [
//            'id_user' => $request->id_user,
//            'status' => AppConst::ORDER_STATUS_PENDING,
//            'id_address' => $request->id_address,
//        ];
//
//        $arrOrder = [];
//        $orders = $request->orders;
//
//        for ($i = 0; $i < count($orders); $i++) {
//            $orderDetail = [
//                'id_product' => $orders[$i]['id_product'],
//                'quantity' => $orders[$i]['total'],
//            ];
//            $arrOrder[$i] = [
//                'order' => $order,
//                'order_detail' => $orderDetail,
//            ];
//        }
//
//        $data = [
//            'orders' => $arrOrder,
//
//        ];
//
//        return $this->service->save($data);
        return $request;
    }

    public function show($id)
    {
        return $this->service->getById($id);
    }

    public function update(OderRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'status' => $request->status,
            'address' => $request->address,
        ];
        return $this->service->save($data);
    }

    public function destroy($id)
    {
        $data = [
            'id' => $id,
            'status' => AppConst::ORDER_STATUS_CANCEL,
        ];
        return $this->service->save($data);

    }

}
