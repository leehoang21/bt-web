<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\OrderDTO;
use App\Models\Cart;
use App\Models\Order;

class CartRepository extends BaseRepository
{
    public function getModel()
    {
        return Cart::class;
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
                    'products:id,name,price,total,description,slug,short_description,serial_number,warranty_period',
                    'products.images:id,url',
                ]
            )
            ->where('id_user', $idUser)
            ->get();

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
