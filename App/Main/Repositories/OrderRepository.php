<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\OrderDTO;
use App\Main\DTO\ProductDTO;
use App\Models\Order;
use App\Models\Product;

class OrderRepository extends BaseRepository
{
    public function getModel()
    {
        return Order::class;
    }

    public function getAll(array $params = [])
    {
        $query = Order::query();
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;

        //statistic
        $start = $params['start'] ?? null;
        $end = $params['end'] ?? null;
        $status = $params['status'] ?? null;
        if (!empty($start) && !empty($end)) {

            if ($status != null) {
                error_log($status);
                $query->where('status', $status);
            }
            $query->whereBetween('updated_at', [$start, $end]);
        }
        //pagination

        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }
        //order by
        $order = [
            'total' => 'SUM(order_details.quantity) ',
            'total_price' => 'SUM(products.price*order_details.quantity) ',
            'status' => 'orders.status ',
        ];

        $orderBy = $params['order_by'] ?? null;

        if (!empty($orderBy)) {
            $orderBy = explode(',', $orderBy);
            $order = $order[$orderBy[0]];
            $orderBy = $order . $orderBy[1];

        } else {
            $orderBy = 'orders.id';
        }
        //select
        $select = "orders.id,orders.id_user,orders.status,SUM(order_details.quantity) as total,SUM(products.price*order_details.quantity) as total_price  ";

        $order = $query->with([

            'user:id,name,email,phone',
            'products:id,name,price',
            'orderDetails:id_order,id_product,quantity'

        ])->selectRaw(
            $select
        )->join('order_details', 'orders.id', '=', 'order_details.id_order')
            ->join('products', 'products.id', '=', 'order_details.id_product')
            ->groupByRaw('orders.id_user,orders.status,orders.id')
            ->orderByRaw($orderBy)
            ->get();
        $order->map(function ($item) {
            $dto = new OrderDTO($item);

            return $dto->formatData();
        });
        $total = $order->count();
        return [
            'orders' => $order,
            'total' => $total,
        ];
    }

    public function getProductById($id)
    {
        $product = Product::query()
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
