<?php

namespace App\Main\Services;

use App\Main\Helpers\Response;
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

    public  function  getEmail(){
        return $this->repository->getEmail();
    }

    public function getAll($data)
    {
        $result = $this->repository->getAll($data);
        $total = $result['total'];
        $limit = $data['limit'];
        $page = $data['page'];
        $paginate = (new \App\Main\Helpers\Response)->paginate($total, $limit, $page);
        return (new \App\Main\Helpers\Response)->responseJsonSuccessPaginate($result['data'], $paginate);
    }

    public function getById($id)
    {
        $data = $this->repository->getById($id);
        if ($data) {
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($data);
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
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
            if($e->getCode() == 23000){
                return (new \App\Main\Helpers\Response)->responseJsonFail("The email has already been taken. ");
            }
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
        $user = $this->repository->findOne('id', $data['id']);
        if (empty($user)) {
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }
        $user->name = $data['data']['name'];
        $user->phone = $data['data']['phone'];
        $user->email = $data['data']['email'];

        $user->save();
        return $user;
    }

    public function delete($id)
    {
        return $this->save(
            [
                'id' => $id,
                'data' => [
                    'status' => 2
                ]
            ]
        );
    }
}
