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
        $whereRaw = [];


        if (!empty($keyword) && !empty($searchFields)) {
            for ($i = 0; $i < count($searchFields); $i++)

                if ($searchFields[$i] == 'name' || $searchFields[$i] == 'description' || $searchFields[$i] == 'slug' || $searchFields[$i] == 'short_description') {
                    $searchFields[$i] = 'products.' . $searchFields[$i];
                    $stringLike = '%' . $keyword[$i] . '%';

                    $whereRaw[$i] = $searchFields[$i] . ' like ' . "'$stringLike'";
                } else if ($searchFields[$i] == 'price_from' && $searchFields[$i] == 'price_to') {
                    $whereRaw[$i] = '(between products.price >= ' . $keyword[$i] . ' and products.price <= ' . $keyword[$i] . ')';
                } else if ($searchFields[$i] == 'price_from') {
                    $whereRaw[$i] = 'products.price >= ' . $keyword[$i];

                } else if ($searchFields[$i] == 'price_to') {
                    $whereRaw[$i] = 'products.price <= ' . $keyword[$i];
                } else if ($searchFields[$i] == 'status') {
                    if ($keyword[$i] == '1') {

                        $whereRaw[$i] = 'products.total > 0';
                    }
                    if ($keyword[$i] == '2') {

                        $whereRaw[$i] = '(products.total < 1 or products.total is null)';
                    }

                } else {
                    return [
                        'message' => 'search field not found',
                        'total' => 0,
                        'products' => [],
                    ];
                }
        }
        if (!empty($whereRaw))

            $query->whereRaw(implode(' and ', $whereRaw));

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

        if ($orderBy == 'new' || $orderBy == 'hot')
            $orderBy = $order[$orderBy];

        $select = "products.total,products.serial_number,products.warranty_period,products.id,products.name,products.slug,products.description,products.short_description,products.price,SUM(order_details.quantity) as order_total";
        $products = $query
            ->leftJoin('order_details', 'products.id', '=', 'order_details.id_product')
            ->selectRaw($select)
            ->groupByRaw('products.total,products.serial_number,products.warranty_period,products.id,products.name,products.slug,products.description,products.short_description,products.price')
            ->with([
                'categories:id,name,slug',
                'images:id,url',
                'orders:id',
                'orders.user:id,name,email,phone',
                'orders.orderDetails:quantity,id_order',

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
            'message' => 'success',

        ];
    }


    public function getProductBySlug($slug)
    {

        $product = Product::query()
            ->where('slug', '=', $slug)
            ->with([
                'categories:id,name,slug',
                'images:id,url',
                'orders:id',
                'tags:id,name',
            ])
            ->first();

        if (empty($product))
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
