<?php

namespace App\Main\Services;

use App\Main\Helpers\Response;
use App\Main\Repositories\AdvisoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use function PHPUnit\Framework\isEmpty;

class AdvisoryService
{
    protected AdvisoryRepository $repository;
    public function __construct(
        AdvisoryRepository $repository,

    )
    {
        $this->repository = $repository;

    }

    public function getAll( $data) {
        $result = $this->repository->getAll($data);
        $message = $result['message'];
        if(isEmpty($message) && $message != 'success'){
            return (new \App\Main\Helpers\Response)->responseJsonFail($message);
        }
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
        return (new \App\Main\Helpers\Response)->responseJsonFail(false, );
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
        $advisory = $this->repository->findOrFail($data['id']);
        if( !isEmpty($data['data']['slug'])){
            $advisory->content = $data['data']['content'];
        }
        if( !isEmpty($data['data']['name'])){
            $advisory->name = $data['data']['name'];
        }
        if( !isEmpty($data['data']['description'])){
            $advisory->email = $data['data']['email'];
        }
        if( !isEmpty($data['data']['image'])){
            $advisory->phone = $data['data']['phone'];
        }
        if( !isEmpty($data['data']['status'])){
            $advisory->status = $data['data']['status'];
        }


        return $this->repository->update('id', $data['id'], $data['data']);
    }

    public function delete($id) {
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }
}
