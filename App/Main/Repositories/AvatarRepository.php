<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Models\Avatar;

class AvatarRepository extends BaseRepository
{
    public function getModel()
    {
        return Avatar::class;
    }

    public function getById($attribute, $id)
    {
        $this->getModel();
        $data = $this->model->
        where($attribute, "=", $id)
            ->with([
                'image:id,url',
            ])
            ->first();
        return $data;
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
