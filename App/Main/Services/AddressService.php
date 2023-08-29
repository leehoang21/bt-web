<?php

namespace App\Main\Services;

use App\Main\Repositories\AddressRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class AddressService
{
    protected AddressRepository $repository;

    public function __construct(
        AddressRepository $repository,

    )
    {
        $this->repository = $repository;

    }

    public function getById($id)
    {
        $data = $this->repository->getById($id);
        if ($data) {
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($data);
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }

    public function getAll($data)
    {
        $data = $this->repository->getAll($data);
        return (new \App\Main\Helpers\Response)->responseJsonSuccess($data['data']);
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

        return $this->repository->create($data['data']);
    }

    private function updateData($data)
    {
        $query = $this->repository->update(
            [
                'id',
            ],
            [
                $data['id'],
            ],
            $data['data'],
        );
        return $query;
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->repository->delete($id);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result, message: true);
    }
}
