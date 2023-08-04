<?php

namespace App\Main\Services;

use App\Main\Repositories\OrderRepository;
use App\Main\Repositories\ProductRepository;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Throwable;

class OrderService
{
    protected OrderRepository $repository;
    protected  OrderDetail $orderDetail;
    public function __construct(
        OrderRepository $repository,
        OrderDetail $orderDetail

    )
    {
        $this->repository = $repository;
        $this->orderDetail = $orderDetail;

    }

    public function getAll( $data) {
        $products = $this->repository->getAll($data);
        $total = $products['total'];
        $limit = $data['limit'];
        $page = $data['page'];
        $paginate = (new \App\Main\Helpers\Response)->paginate($total, $limit, $page);
        return (new \App\Main\Helpers\Response)->responseJsonSuccessPaginate($products['orders'], $paginate);
    }

    public function getById($id) {
        $product = $this->repository->getById($id);
        if($product){
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($product);
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }

    public function getOrderById($id) {
        $product = $this->repository->getProductById($id);
        if($product){
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($product);
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }

    public function save($data) {
        DB::beginTransaction();
        try{
            if(empty($data['id'])) {
                $result = $this->createData($data);
            } else {
                $result = $this->updateData($data);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

    private function createData($data) {

        $orders = $data['orders'];

        $result = $this->repository->create($orders[0]['order']);
        $products = [];
        $array_total = [];

        for ($i = 0; $i < count($orders); $i++) {
            $orders[$i]['order_detail']['id_order'] = $result->id;
            $products[$i] = $orders[$i]['order_detail']['id_product'];
            $array_total[$i] = $orders[$i]['order_detail']['quantity'];


            $result2 = $this->orderDetail->create($orders[$i]['order_detail']);
            if (!$result2) {
                return (new \App\Main\Helpers\Response)->responseJsonFail(false);
            }
        }
        return  [
            'id' => $result->id,
            'status' => $result->status,
            'address' => $result->address,
            'created_at' => $result->created_at,
            'updated_at' => $result->updated_at,
            'products' => $products,
            'total' => $array_total,
        ];

    }


    private function updateData($data) {

        $value = [
            'status' => $data['status'],
        ];
        return $this->repository->update('id', $data['id'],$value);
    }

}
