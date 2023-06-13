<?php

namespace App\Main\Services;

use App\Main\Repositories\OrderRepository;
use App\Main\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use Throwable;

class OrderService
{
    protected OrderRepository $repository;
    public function __construct(
        OrderRepository $repository,

    )
    {
        $this->repository = $repository;

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
            $result = $this->updateData($data);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }


    private function updateData($data) {
        $value = [
            'status' => $data['status'],
        ];
        return $this->repository->update('id', $data['id'],$value);
    }

}
