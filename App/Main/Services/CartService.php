<?php

namespace App\Main\Services;

use App\Main\Repositories\CartRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CartService
{
    protected CartRepository $repository;

    public function __construct(
        CartRepository $repository,
    )
    {
        $this->repository = $repository;
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
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

    private function createData($data)
    {

        $data = $data['data'];

        $result = $this->repository->create($data);
        return $result;
    }

    public function updateData($data)
    {
        $id = $data['id'];
        $query = $this->repository->findOrFail($id);
        if (!$query) {
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }
        foreach ($data['data'] as $key => $value) {
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
