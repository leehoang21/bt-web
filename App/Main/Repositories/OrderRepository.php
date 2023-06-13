<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\OrderDTO;
use App\Main\DTO\ProductDTO;
use App\Models\Advisory;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository
{
    public function getModel()
    {
        return Order::class;
    }

    public function getAll(array $params = [], $orderBy = 'status')
    {
        $query = Order::query();
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;
        $status = $params['status'] ?? null;
        if (!empty($status) ) {
            $query->where('status', $status);
        }
        $total = $query->count();
        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }
        $query->get();
        $order = $query->with([
            'orderDetails:quantity,price,id_order',
            'user:id,name,email,phone',
            'products:id,name,price,slug',

        ])
            ->orderBy($orderBy)
            ->get();

        $order->map(function ($item) {
            $dto = new OrderDTO($item);
            return $dto->formatData();
        });
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
