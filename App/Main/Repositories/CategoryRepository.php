<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\CategoryDTO;
use App\Models\Category;


class CategoryRepository extends BaseRepository
{
    public function getModel()
    {
        return Category::class;
    }

    public function getAll(array $params = [], $orderBy = 'id')
    {
        $query = Category::query();

        //search
        $keyword = $params['keyword'] == null ? null : explode(',', $params['keyword']);
        $searchFields = $params['search_fields'] == null ? null : explode(',', $params['search_fields']);

        if (!empty($keyword) && !empty($searchFields)) {
            for ($i = 0; $i < count($searchFields); $i++)

                if ($searchFields[$i] == 'name' || $searchFields[$i] == 'slug') {

                    $stringLike = '%' . $keyword[$i] . '%';

                    $query->where($searchFields[$i], 'like', $stringLike);
                }else {
                    return [
                        'message' => 'search field not found',
                        'total' => 0,
                        'data' => [],

                    ];
                }
        }

        $total = $query->count();
        //pagination
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;
        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }
        $query->get();
        $data = $query
            ->with(
                [
                    'images:id,url',
                ]
            )
            ->orderBy($orderBy)

            ->get();

        $data->map(function ($item) {
            $dto = new CategoryDTO($item);
            return $dto->formatData();
        });
        return [
            'data' => $data,
            'total' => $total,
            'message' => 'success',
        ];
    }

    public function getById($id)
    {
        $data = Category::query()
            ->with(
                [
                    'images:id,url',
                ])

            ->find($id);
        $dto = new CategoryDTO($data);
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
