<?php

namespace App\Main\Services;

use App\Main\Repositories\OrderRepository;
use App\Main\Repositories\ProductRepository;
use App\Models\OrderDetail;
use Throwable;

class OrderService
{
    protected OrderRepository $repository;
    protected OrderDetail $orderDetail;
    protected  $productRepository;

    public function __construct(
        OrderRepository $repository,
        OrderDetail     $orderDetail,
        ProductRepository $productRepository

    )
    {
        $this->repository = $repository;
        $this->orderDetail = $orderDetail;
        $this->productRepository = $productRepository;

    }

    public function getAll($data)
    {
        $products = $this->repository->getAll($data);
        $total = $products['total'];
        $limit = $data['limit'];
        $page = $data['page'];
        $paginate = (new \App\Main\Helpers\Response)->paginate($total, $limit, $page);
        return (new \App\Main\Helpers\Response)->responseJsonSuccessPaginate($products['orders'], $paginate);
    }

    public function getById($id)
    {
        $product = $this->repository->getById($id);
        if ($product) {
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($product);
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }

    public function getOrderById($id)
    {
        $product = $this->repository->getProductById($id);
        if ($product) {
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($product);
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }

    public function save($data)
    {

        try {
            if (empty($data['id'])) {
                $result = $this->createData($data);
            } else {
                $result = $this->updateData($data);
            }
        } catch (Throwable $e) {

            return (new \App\Main\Helpers\Response)->responseJsonFail($e->getMessage());
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

    /**
     * @throws \Exception
     */
    private function createData($data)
    {

        $orders = $data['orders'];

        $result = $this->repository->create($orders[0]['order']);
        $products = [];
        $array_total = [];

        for ($i = 0; $i < count($orders); $i++) {
            $orders[$i]['order_detail']['id_order'] = $result->id;
            $products[$i] = $orders[$i]['order_detail']['id_product'];
            $array_total[$i] = $orders[$i]['order_detail']['quantity'];
            //
            $this->isMoreProduct($products[$i],$array_total[$i]);
            //
            $result2 = $this->orderDetail->create($orders[$i]['order_detail']);
            if (!$result2) {
                throw   new \Exception('Create order detail fail');
            }
        }
        return [
            'id' => $result->id,
            'user' => $result->with([
                'user:id,name,email'
            ])
                ->where('id_user', $result->id_user)
                ->first()
                ->user
            ,
            'status' => $result->status,
            'address' => $result->with([
                'address:id,address,phone'
            ])
                ->where('id_address', $result->id_address)
                ->first()
                ->address,
            'created_at' => $result->created_at,
            'updated_at' => $result->updated_at,
            'products' => $products,
            'total' => $array_total,
        ];

    }
    private function isMoreProduct(int $id, int $quantity)
    {
        $products = $this->productRepository
            ->find($id);
        if($products == null) {
            throw new \Exception('Not found');
        }else{
            $products = $products->first();
        }

        if ($products->total >= $quantity) {
            return true;
        }
        throw new \Exception('The quantity of product is not enough');
    }


    private function updateData($data)
    {

        $value = [
            'status' => $data['status'],
        ];
        return $this->repository->update('id', $data['id'], $value);
    }

}
