<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\ImageDTO;
use App\Models\Image;


class ImageRepository extends BaseRepository
{
    public function getModel()
    {
        return Image::class;
    }

    public function getAll(array $params = [], $orderBy = 'id')
    {
        $query = Image::query();
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;

        $total = $query->count();
        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }
        $query->get();
        $data = $query
            ->orderBy($orderBy)

            ->get();

        $data->map(function ($item) {
            $dto = new ImageDTO($item);
            return $dto->formatData();
        });
        return [
            'data' => $data,
            'total' => $total,
        ];
    }

    public function getById($id)
    {
        $data = Image::query()

            ->find($id);
        $dto = new ImageDTO($data);
        return $dto->formatData();
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
