<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\AdvisoryDTO;

use App\Models\Advisory;



class AdvisoryRepository extends BaseRepository
{
    public function getModel()
    {
        return Advisory::class;
    }

    public function getAll(array $params = [], $orderBy = 'id')
    {
        $query = Advisory::query();
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;
        if (!empty($params['key_word']) && is_string($params['key_word'])) {
            $stringLike = '%' . $params['key_word'] . '%';
            $query->where('name', 'like', $stringLike);

        }
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
            $dto = new AdvisoryDTO($item);
            return $dto->formatData();
        });
        return [
            'data' => $data,
            'total' => $total,
        ];
    }

    public function getById($id): \App\Models\Advisory
    {
        $post = Advisory::query()

            ->find($id);
        $dto = new AdvisoryDTO($post);
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
