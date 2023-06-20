<?php

namespace App\Main\Services;

use App\Main\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserService
{
    protected UserRepository $repository;
    public function __construct(
        UserRepository $repository,

    )
    {
        $this->repository = $repository;

    }

    public function getAll( $data) {
        $result = $this->repository->getAll($data);
        $total = $result['total'];
        $limit = $data['limit'];
        $page = $data['page'];
        $paginate = (new \App\Main\Helpers\Response)->paginate($total, $limit, $page);
        return (new \App\Main\Helpers\Response)->responseJsonSuccessPaginate($result['data'], $paginate);
    }

    public function getById($id) {
        $data = $this->repository->getById($id);
        if($data){
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($data);
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

        return $this->repository->create($data['data']);
    }

    private function updateData($data) {

        return $this->repository->update('id', $data['id'], $data['data']);
    }

    public function delete($id) {
      return  $this->save(
            [
                'id' => $id,
                'data' => [
                    'status' => 2
                ]
            ]
        );
    }
}
