<?php

namespace App\Main\Repositories;
use App\Main\BaseResponse\BaseRepository;
use App\Models\User;

/**
 *
 */
class UserRepository extends BaseRepository
{
    public function getModel()
    {
        return User::class;
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
