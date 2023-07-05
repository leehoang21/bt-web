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

    public function getAllProducts(array $params = [], $orderBy = 'products.id')
    {
        $query = Product::query();
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;

        //search
        $keyword = $params['keyword'] == null ? null : explode(',', $params['keyword']);
        $searchFields = $params['search_fields'] == null ? null : explode(',', $params['search_fields']);

        if (!empty($keyword) && !empty($searchFields)) {
            for ($i = 0; $i < count($searchFields); $i++) {
                $searchFields[$i] = 'products.' . $searchFields[$i];
                $stringLike = '%' . $keyword[$i] . '%';
                $query->where($searchFields[$i], 'like', $stringLike);
            }

        }


        //pagination
        $total = $query->count();
        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }

        //order by
        $order = [
            'new' => 'id desc',
            'hot' => 'SUM(order_details.quantity)  desc',
        ];

        if($orderBy == 'new' || $orderBy == 'hot')
            $orderBy = $order[$orderBy];

        $select = "products.total,products.serial_number,products.warranty_period,products.id,products.name,products.slug,products.description,products.short_description,products.price,products.id_category,SUM(order_details.quantity) as total";
        $products = $query
            ->leftJoin('order_details', 'products.id', '=', 'order_details.id_product')
            ->selectRaw($select)
            ->groupByRaw('products.total,products.serial_number,products.warranty_period,products.id,products.name,products.slug,products.description,products.short_description,products.price,products.id_category')

            ->with([
            'category:id,name,slug',
            'images:id,url',
            'orders:id',
            'tags:id,name',

        ])
            ->orderByRaw($orderBy)
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

    public  function  getProductBySlug($slug){
        $product = $this->findOne('slug',$slug);
        if(empty($product))
            return null;
        $dto = new ProductDTO($product);
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
