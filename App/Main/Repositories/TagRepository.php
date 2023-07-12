<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\TagDTO;
use App\Models\Tag;


class TagRepository extends BaseRepository
{
    public function getModel()
    {
        return Tag::class;
    }

    public function getAll(array $params = [], $orderBy = 'id')
    {
        $query = Tag::query();
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;
        if (!empty($params['key_word']) && is_string($params['key_word'])) {
            $stringLike = '%' . $params['key_word'] . '%';
            $query->where('content', 'like', $stringLike);

        }
        //search
        $keyword = $params['keyword'] == null ? null : explode(',', $params['keyword']);
        $searchFields = $params['search_fields'] == null ? null : explode(',', $params['search_fields']);

        if (!empty($keyword) && !empty($searchFields)) {
            for ($i = 0; $i < count($searchFields); $i++)

                if ($searchFields[$i] == 'name') {

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
        //pagination
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
            $dto = new TagDTO($item);
            return $dto->formatData();
        });
        return [
            'data' => $data,
            'total' => $total,
        ];
    }

    public function getById($id)
    {
        $data = Tag::query()

            ->find($id);
        $dto = new TagDTO($data);
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
