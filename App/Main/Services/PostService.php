<?php

namespace App\Main\Services;

use App\Main\Helpers\Response;
use App\Main\Repositories\PostRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use function PHPUnit\Framework\isEmpty;

class PostService
{
    protected PostRepository $repository;
    public function __construct(
        PostRepository $repository,

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
        return (new \App\Main\Helpers\Response)->responseJsonSuccessPaginate($result['posts'], $paginate);
    }

    public function getById($id) {
        $data = $this->repository->getById($id);
        if($data){
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($data);
        }
        return (new \App\Main\Helpers\Response)->responseJsonFail(false);
    }

    public function getBySlug($slug) {
        $data = $this->repository->getBySlug($slug);
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
            if ($e->getCode() == 23000) {
                return (new Response)->responseJsonFail(message: 'The slug has already been taken.',httpCode: Response::HTTP_CODE_UNAUTHORIZED);
            }
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

    private function createData($data) {
        return $this->repository->create($data['post']);
    }

    private function updateData($data) {

        return $this->repository->update('id', $data['id'], $data['post']);
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

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }
}
