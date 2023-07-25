<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\OrderDTO;
use App\Models\Order;
use mysql_xdevapi\Collection;
use function PHPUnit\Framework\isEmpty;

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

        //search
        $keyword = $params['keyword'] == null ? null : explode(',', $params['keyword']);
        $searchFields = $params['search_fields'] == null ? null : explode(',', $params['search_fields']);
        $name = null;

        if (!empty($keyword) && !empty($searchFields)) {
            for ($i = 0; $i < count($searchFields); $i++)

                if ($searchFields[$i] == 'name') {
                    $name = $keyword[$i];
                } else if ($searchFields[$i] == 'status') {
                    $query->where('orders.status', $keyword[$i]);
                } else {
                    return [
                        'message' => 'search field not found',
                        'total' => 0,
                        'orders' => [],
                    ];
                }
        }


        $total = $query->get()->count();
        //pagination

        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }

        //get
        $order = $query
            ->join('users', 'orders.id_user', '=', 'users.id')
            ->with(
                [
                    'user:id,name,phone,email',
                    'user.avatar:id,url',
                    'orderDetails:id_order,id_product,quantity',
                    'products:id,name,price,total,description,slug,short_description,serial_number,warranty_period',

                ]
            )
            ->select(
                'orders.id',
                'orders.id_user',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
                'users.name as name_user',


            )
            ->where('users.name', 'like', '%' . $name . '%')
            ->get();



        return [
            'orders' => $order,
            'total' => $total,
            'message' => 'success',
        ];
    }


    public function getProductById($id)
    {
        $product = $this->find($id);
        if ($product) {
            $data = new OrderDTO($product);
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
