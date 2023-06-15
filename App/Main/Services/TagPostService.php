<?php

namespace App\Main\Services;
use App\Main\Repositories\TagPostRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class TagPostService
{
    protected TagPostRepository $repository;
    public function __construct(
        TagPostRepository $repository,

    )
    {
        $this->repository = $repository;

    }

    public function createData($id,$images ) {
        DB::beginTransaction();
        try{
            for ($i=0; $i < count($images); $i++) {
                $result =  $this->repository->create(
                    [
                        'id_post' => $id,
                        'id_tag' => $images[$i],
                    ]
                );
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

    public  function  updateData($id,$images){
        DB::beginTransaction();
        try{
            $this->repository->deleteWhere('id_post',$id);
            for ($i=0; $i < count($images); $i++) {
                $result =  $this->repository->create(
                    [
                        'id_post' => $id,
                        'id_tag' => $images[$i],
                    ]
                );
            }
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

        return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
    }

}
