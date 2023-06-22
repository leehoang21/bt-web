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

        $result = $this->repository->create($data['order']);
        $data['order_detail']['id_order'] = $result->id;
        $result2 = $this->orderDetail->create($data['order_detail']);
        if(!$result || !$result2 ){
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }
        return  [
            'id' => $result->id,

            'status' => $result->status,
            'created_at' => $result->created_at,
            'updated_at' => $result->updated_at,
            'id_product' => $result2->id_product,
            'total' => $result2->quantity,
        ];

    }


    private function updateData($data) {
        $value = [
            'status' => $data['status'],
        ];
        return $this->repository->update('id', $data['id'],$value);
    }

}
