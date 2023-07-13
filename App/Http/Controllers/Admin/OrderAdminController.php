<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOderRequest;
use App\Http\Requests\OderRequest;
use App\Main\Config\AppConst;
use App\Main\Services\OrderService;
use Illuminate\Http\Request;

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
            'start' => $request->start,
            'end' => $request->end,
            'status' => $request->status,
            //'order_by' => $request->order_by,
        ];
        return $this->service->getAll($data);
    }

    public function store(CreateOderRequest $request)
    {

        $order = [
            'id_user' => $request->id_user,
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

    public function show()
    {
        return 'show';
    }

    public function update(OderRequest $request, $id)
    {
        $data = [
            'id' => $id,
            'status' => $request->status,
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
