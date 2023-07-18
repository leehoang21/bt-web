<?php

namespace App\Main\Services;

use App\Main\Repositories\AdminRepository;
use App\Main\Repositories\DashboardRepository;
use App\Main\Repositories\ProductRepository;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class DashboardService
{
    protected DashboardRepository $repository;
    public function __construct(
        DashboardRepository $repository,
    )
    {
        $this->repository = $repository;
    }

    public function getRevenue( $data) {
        $result = $this->repository->getRevenue($data);
        $data = $result['data'];
        return (new \App\Main\Helpers\Response)->responseJsonSuccess($data, );
    }

    public function getBySlug($slug) {
        $result =  $this->repository->getProductBySlug($slug);
        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
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
        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
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
