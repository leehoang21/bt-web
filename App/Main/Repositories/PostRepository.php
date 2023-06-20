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
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;
        if (!empty($params['key_word']) && is_string($params['key_word'])) {
            $stringLike = '%' . $params['key_word'] . '%';
            $query->where('content', 'like', $stringLike);

        }
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
        ];
    }

    public function getById($id)
    {
        $post = Post::query()
            ->with([
                'images:url',
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
                'images:url',
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
