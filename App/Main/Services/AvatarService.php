<?php

namespace App\Main\Services;
use App\Main\Repositories\AvatarRepository;
use App\Main\Repositories\ImageRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class AvatarService
{
    protected AvatarRepository $repository;
    protected  ImageRepository $imageRepository;
    public function __construct(
        AvatarRepository $repository,
        ImageRepository $imageRepository

    )
    {
        $this->repository = $repository;
        $this->imageRepository = $imageRepository;

    }
    public  function  save($id,$imageId){
        DB::beginTransaction();
        try{
            $this->repository->deleteWhere('id_user',$id);
            $result =  $this->repository->create(
                [
                    'id_user' => $id,
                    'id_image' => $imageId,
                ]
            );

            DB::commit();
            $result = $this->repository->getById('id_user',$id,);
            return (new \App\Main\Helpers\Response)->responseJsonSuccess($result);
        } catch (Throwable $e) {
            DB::rollBack();
            error_log($e->getMessage());
            return (new \App\Main\Helpers\Response)->responseJsonFail(false);
        }

    }

}
