<?php

namespace App\Main\Services;

use App\Main\Repositories\FavoriteRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class FavoriteService
{
    protected FavoriteRepository $repository;

    public function __construct(
        FavoriteRepository $repository,

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
            $result = $this->createData($data);
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

        $result = $this->repository->create($data);

        $result = $result->
        with(
            [
                'user:id,name,phone,email',
                'user.avatar:id,url',
                'product:id,name,price,total,description,slug,short_description,serial_number,warranty_period',
                'product.images:id,url',
            ]
        )
            ->whereRaw(
                'id_user = ' . $data['id_user'] . ' and id_product = ' . $data['id_product']
            )
            ->first();
        return $result;


    }



    public function delete($favorite)
    {
        DB::beginTransaction();
        try {

            DB::commit();

            return $this->repository->destroy($favorite);
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());

            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }
    }

}
