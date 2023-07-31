<?php

namespace App\Main\Services;

use App\Main\Repositories\TagRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use function PHPUnit\Framework\isEmpty;

class TagService
{
    protected TagRepository $repository;
    public function __construct(
        TagRepository $repository,
    )
    {
        $this->repository = $repository;

    }

    public function getAll( $data) {
        $result = $this->repository->getAll($data);
        if(isEmpty($data['limit'])){
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($result['data']);
        }
        $total = $result['total'];
        $limit = $data['limit'] ;
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
            if($e->getCode() == 23000) {
                return (new \App\Main\Helpers\Response)->responseJsonFail( message: 'The slug has already been taken.');
            }
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
        DB::beginTransaction();
        try{
            $product = $this->repository->findOrFail($id);

            $result = $this->repository->delete($id);
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();

            Log::warning($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess(null,message: true);
    }
}
