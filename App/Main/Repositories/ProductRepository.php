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

    public function getProductById($id)
    {
        $product = Product::query()
            ->with([
                'category:id,name,slug',
                'images:id,url',
                'orders:id,status',
                'tags:id,name',

            ])
            ->find($id);
        if ($product) {
            $data = new ProductDTO($product);
            return $data->formatDataDetailProduct();
        }

        return $product;

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
