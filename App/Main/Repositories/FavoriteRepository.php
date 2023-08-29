<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Models\Favorite;

class FavoriteRepository extends BaseRepository
{
    public function getModel()
    {
        return Favorite::class;
    }

    public function getAll(array $params = [])

    {
         $idUser = $params['id_user'];
        //get
        $data = $this
            ->model

            ->with(
                [
                    'user:id,name,phone,email',
                    'user.avatar:id,url',
                    'product:id,name,price,total,description,slug,short_description,serial_number,warranty_period',
                    'product.images:id,url',
                ]
            )
            ->where('id_user', $idUser)
            ->get();

        return [
            'data' => $data,
            'message' => 'success',
        ];
    }


    public function destroy(array $params)
    {
        $idUser = $params['id_user'];
        $idProduct = $params['id_product'];
        //get
        $query = Favorite::query();
        $query->whereRaw(
            'id_user = ' . $idUser . ' and id_product = ' . $idProduct
        );
        $data = $query->delete();

        return [
            'data' => $data,
            'message' => 'success',
        ];
    }




    public function has(string $name)
    {
        $this->has($name);
    }

    public function get(string $name)
    {
        $this->get($name);
    }

    public function set(string $name, string $value)
    {
        $this->set($name, $value);
    }

    public function clear(string $name)
    {
        $this->clear($name);
    }
}
