<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Models\Product;

class DashboardRepository extends BaseRepository
{
    public function getModel()
    {
        return Product::class;
    }

    public function getRevenue(array $params = [])
    {
        $query = Product::query();

        $select = "SUM(order_details.quantity*products.price) as total_price,month(order_details.updated_at) as month, year(order_details.updated_at) as year";
        $products = $query
            ->Join('order_details', 'products.id', '=', 'order_details.id_product')
            ->join('orders', 'orders.id', '=', 'order_details.id_order')
            ->selectRaw($select)
            ->groupByRaw("orders.status,".'month(order_details.updated_at),year(order_details.updated_at)')
            ->orderByRaw("month(order_details.updated_at),year(order_details.updated_at)")
            ->having('orders.status', '=', 1)
            ->get();


        return [
            'data' => $products,

        ];
    }

    public function getHotProducts(array $params = [])
    {
        $orderBy = $params['order_by'] ?? 'total';
        //order by
        $order = [
            'price' => 'SUM(order_details.quantity*products.price) desc',
            'total' => 'SUM(order_details.quantity) desc',
        ];
        if ($orderBy == 'price' || $orderBy == 'total')
            $orderBy = $order[$orderBy];
        else
            $orderBy = $order['total'];
        //query
        $query = Product::query();

        $select = "SUM(order_details.quantity*products.price) as total_price,SUM(order_details.quantity) as total," .
            "products.id," .
            "products.name," .
            "products.slug," .
            "products.price," .
            "products.short_description," .
            "products.description," .

            "products.total as total_product";


        $products = $query
            ->leftJoin('order_details', 'products.id', '=', 'order_details.id_product')

            ->selectRaw($select)
            ->with([
                'categories:id,name,slug',
                'images:id,url',
                'orders:id',
                'orders.user:id,name,email,phone',
                'orders.orderDetails:quantity,id_order',
                'tags:id,name',

            ])
            ->groupByRaw(
                "products.id," .
                "products.name," .
                "products.slug," .
                "products.price," .
                "products.short_description," .
                "products.description," .

                "products.total "
            )
            ->orderByRaw($orderBy)
            ->limit(10)

            ->get();


        return [
            'data' => $products,

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
