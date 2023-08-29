<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Models\Address;

/**
 *
 */
class AddressRepository extends BaseRepository
{
    public function getModel()
    {
        return Address::class;
    }

    public function getAll(array $params = [])

    {
        $idUser = $params['id_user'];
        //get
        $data = $this
            ->model

            ->where('id_user', $idUser)
            ->get();

        return [
            'data' => $data,
            'message' => 'success',
        ];
    }

    public function getById($id)
    {
        $data = Address::query()
            ->find($id)
            ->first();
        return $data;
    }

    public function update($attribute, $value, array $data)
    {

        //
        $where = [];
        for ($i = 0; $i < count($attribute); $i++) {
            $where[$i] =$attribute[$i]. ' = ' . $value[$i];
        }

        $whereRaw = implode(' and ', $where);

        //update
       $query =  Address::query()->whereRaw($whereRaw)->update($data);

        return $data;
    }

    public function create($data = [])
    {
        return parent::create($data);
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
        clear($name);
    }
}
