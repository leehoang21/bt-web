<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\ProductDTO;
use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function getModel()
    {
        return Product::class;
    }

    public function getAllProducts(array $params = [], $orderBy = 'id')
    {
        $query = Product::query();
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;

        //search
        if (!empty($params['name']) && is_string($params['name'])) {
            $stringLike = '%' . $params['name'] . '%';
            $query->where('name', 'like', $stringLike);

        }


        //pagination
        $total = $query->count();
        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }
        $products = $query->with([
            'category:id,name,slug',
            'images:id,url',
            'orders:id',
            'tags:id,name',

        ])
            ->orderBy($orderBy)
            ->get();

        $products->map(function ($item) {
            $dto = new ProductDTO($item);
            return $dto->formatData();
        });
        return [
            'products' => $products,
            'total' => $total,
        ];
    }

    public function getProductBySlugCategory($slug,$params)
    {
        $select = "products.id,products.name,products.description,products.short_description,products.price,categories.slug as category_slug,
        categories.name as category_name,
        categories.id as category_id
        ";
        $query = Product::query()
            ->join('categories', 'products.id_category', '=', 'categories.id')
            ->selectRaw($select
            )->with([

                'images:id,url',
                'orders:id',
                'tags:id,name',

            ]);
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;
        //search
        if (!empty($params['name']) && is_string($params['name'])) {
            $stringLike = '%' . $params['name'] . '%';
            $query->where('name', 'like', $stringLike);

        }
        //pagination
        $total = $query->count();
        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;

            $query->limit($limit)->offset($offset);
        }
        $stringLikeSlug = '%' . $slug. '%';
        $products = $query
            ->where('categories.slug','like', $stringLikeSlug)
            ->get();
        $products->map(function ($item) {
            $dto = new ProductDTO($item);
            return $dto->formatData();
        });
        return [
            'products' => $products,
            'total' => $total,
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
