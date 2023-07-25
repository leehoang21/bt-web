<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\PostDTO;
use App\Models\Post;


class PostRepository extends BaseRepository
{
    public function getModel()
    {
        return Post::class;
    }

    public function getAll(array $params = [], $orderBy = 'id')
    {
        $query = Post::query();
        //search
        $keyword = $params['keyword'] == null ? null : explode(',', $params['keyword']);
        $searchFields = $params['search_fields'] == null ? null : explode(',', $params['search_fields']);
        $whereRaw = [];
        if (!empty($keyword) && !empty($searchFields)) {
            for ($i = 0; $i < count($searchFields); $i++)

                if ($searchFields[$i] == 'title' || $searchFields[$i] == 'content' || $searchFields[$i] == 'slug' ) {
                    $stringLike = '%' . $keyword[$i] . '%';
                    $whereRaw[$i] = $searchFields[$i] . ' like ' . "'$stringLike'";
                }  else {
                    return [
                        'message' => 'search field not found',
                        'total' => 0,
                        'posts' => [],
                    ];
                }
        }
        if (!empty($whereRaw))
            $query->whereRaw(implode(' and ', $whereRaw));

        //pagination
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;
        $total = $query->count();
        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }
        $query->get();
        $post = $query->with([
            'images:id,url',
            'tags:name,id,slug'
        ])
            ->orderBy($orderBy)
            ->get();

        $post->map(function ($item) {
            $dto = new PostDTO($item);
            return $dto->formatData();
        });
        return [
            'posts' => $post,
            'total' => $total,
            'message' => 'success',
        ];
    }

    public function getById($id)
    {
        $post = Post::query()
            ->with([
                'images:url,id',
                'tags:name,id,slug'
            ])
            ->find($id);
        $dto = new PostDTO($post);
        return $dto->formatData();
    }

    public function getBySlug($slug)
    {
        $post = Post::query()
            ->with([
                'images:url,id',
            ]);
        $post = $post->where('slug', $slug)->first();
        $dto = new PostDTO($post);
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
