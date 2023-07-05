<?php

namespace App\Main\Services;

use App\Main\DTO\ProductDTO;
use App\Main\Helpers\Response;
use App\Main\Repositories\AdminRepository;
use App\Main\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductService
{
    protected AdminRepository $adminRepository;
    public function __construct(
        ProductRepository $repository,


    )
    {
        $this->repository = $repository;

    }

    public function getAllProducts( $data,$orderBy) {
        $products = $this->repository->getAllProducts($data,$orderBy);
        $total = $products['total'];
        $limit = $data['limit'];
        $page = $data['page'];
        $paginate = (new \App\Main\Helpers\Response)->paginate($total, $limit, $page);
        return (new \App\Main\Helpers\Response)->responseJsonSuccessPaginate($products['products'], $paginate);
    }

    public function getBySlug($slug) {
        return $this->repository->getProductBySlug($slug);
    }

    public function getProductBySlugCategory($slug,$data) {
        $products = $this->repository->getProductBySlugCategory($slug,$data);
        $total = $products['total'];
        $limit = $data['limit'];
        $page = $data['page'];
        $paginate = (new \App\Main\Helpers\Response)->paginate($total, $limit, $page);
        return (new \App\Main\Helpers\Response)->responseJsonSuccessPaginate($products['products'], $paginate);
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
        return (new \App\Main\Helpers\Response)->responseJsonSuccess(null,message: true);
    }

    private function createData($data) {
        return $this->repository->create($data['product']);
    }

    private function updateData($data) {

        return $this->repository->update('id', $data['id'], $data['product']);
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

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result,message: true);
    }
}
