<?php

namespace App\Main\Services;

use App\Main\Repositories\CartRepository;
use App\Main\Repositories\ProductRepository;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CartService
{
    protected CartRepository $repository;
    protected $productRepository;

    public function __construct(
        CartRepository    $repository,
        ProductRepository $productRepository

    )
    {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
    }

    public function getAll($data)
    {
        $products = $this->repository->getAll($data);
        return (new \App\Main\Helpers\Response)->responseJsonSuccess($products['data']);
    }

    public function save($data)
    {
        DB::beginTransaction();
        try {
            if (empty($data['id'])) {
                $result = $this->createData($data);
            } else {
                $result = $this->updateData($data);
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail($e->getMessage());
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

    private function createData($data)
    {

        $data = $data['data'];
        $cart = Cart::query()
            ->whereRaw('id_user = ? and id_product = ?', [$data['id_user'], $data['id_product']])
            ->first();

        if ($cart != null) {
            $cart->quantity = $cart->quantity + $data['quantity'];

            if ($this->isMoreProduct($data['id_product'], $cart->quantity)) {

                $cart->save();
                return $cart;
            }

        } else {
            if ($this->isMoreProduct($data['id_product'], $data['quantity'])) {
                error_log('create');
                $result = $this->repository->create($data);
                return $result;
            }
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }


    /**
     * @throws \Exception
     */
    private function isMoreProduct(int $id, int $quantity)
    {
        $products = $this->productRepository
            ->findOrFail($id);
        if($products == null) {
            throw new \Exception('Not found');
        }
        error_log($products->name);
        if ($products->total >= $quantity) {
            return true;
        }
        throw new \Exception('The quantity of product is not enough');
    }

    /**
     * @throws \Exception
     */
    public function updateData($data)
    {
        $id = $data['id'];
        $data = $data['data'];

        try {
            $query = $this->repository->findOrFail($id);
        } catch (\Exception $e) {
            throw  new \Exception('Not found');
        }

        if (!$query) {
            throw  new \Exception('Not found');
        }
        if (!($this->isMoreProduct($query['id_product'], $data['quantity']))) {
            throw new \Exception('The quantity of product is not enough');
        }
        foreach ($data as $key => $value) {
            $query->$key = $value;
        }
        $query->save();
        return $query;
    }


    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->repository->findOrFail($id);
            $result = $this->repository->delete($id);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            Log::warning($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

}
