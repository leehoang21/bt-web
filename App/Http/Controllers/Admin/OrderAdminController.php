<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOderRequest;
use App\Http\Requests\OderRequest;
use App\Main\Config\AppConst;
use App\Main\Services\OrderService;
use Illuminate\Http\Request;
use function Sodium\add;

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

        $order = [
            'id_user' => $request->id_user,
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
