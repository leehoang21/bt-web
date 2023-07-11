<?php

namespace App\Main\Services;
use App\Main\Repositories\ImageCategoryRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class ImageCategoryService
{
    protected ImageCategoryRepository $repository;
    public function __construct(
        ImageCategoryRepository $repository,

    )
    {
        $this->repository = $repository;

    }

    public function createData($id,$images ) {
        DB::beginTransaction();


        try{
            for ($i=0; $i < count($images); $i++) {
                $this->repository->create(
                    [
                        'id_category' => $id,
                        'id_image' => $images[$i],
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

    public  function  updateData($id,$images){
        DB::beginTransaction();
        try{

            $this->repository->deleteWhere('id_category',$id);

            for ($i=0; $i < count($images); $i++) {
                $this->repository->create(
                    [
                        'id_category' => $id,
                        'id_image' => $images[$i],
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
