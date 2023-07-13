<?php

namespace App\Main\Services;
use App\Main\Repositories\ProductCategoryRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProductCategoryService
{
    protected ProductCategoryRepository $repository;
    public function __construct(
        ProductCategoryRepository $repository,

    )
    {
        $this->repository = $repository;

    }

    public function createData($id,$categories ) {
        DB::beginTransaction();


        try{
            for ($i=0; $i < count($categories); $i++) {
                $this->repository->create(
                    [
                        'id_product' => $id,
                        'id_category' => $categories[$i],
                    ]
                );
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess(true,message: 'update success');
    }

    public  function  updateData($id,$categories){
        DB::beginTransaction();
        try{

            $this->repository->deleteWhere('id_category',$id);

            for ($i=0; $i < count($categories); $i++) {
                $this->repository->create(
                    [
                        'id_product' => $id,
                        'id_category' => $categories[$i],
                    ]
                );
            }
            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess(true,message: 'update success');
    }

}
