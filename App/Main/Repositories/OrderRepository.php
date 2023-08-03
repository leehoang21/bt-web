<?php

namespace App\Main\Repositories;

use App\Main\BaseResponse\BaseRepository;
use App\Main\DTO\OrderDTO;
use App\Models\Order;
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

        //search
        $keyword = $params['keyword'] == null ? null : explode(',', $params['keyword']);
        $searchFields = $params['search_fields'] == null ? null : explode(',', $params['search_fields']);
        $whereRaw = [];


        if (!empty($keyword) && !empty($searchFields)) {
            for ($i = 0; $i < count($searchFields); $i++)

                if ($searchFields[$i] == 'name') {
                    $searchFields[$i] = 'users.name';
                    $stringLike = '%' . $keyword[$i] . '%';

                    $whereRaw[$i] = $searchFields[$i] . ' like ' . "'$stringLike'";
                } else if ($searchFields[$i] == 'status') {
                    $searchFields[$i] = 'orders.status';
                    $stringLike = $keyword[$i];

                    $whereRaw[$i] = $searchFields[$i] . ' = ' . "'$stringLike'";
                } else if ($searchFields[$i] == 'id_user') {
                    $searchFields[$i] = 'orders.id_user';
                    $stringLike = $keyword[$i];

                    $whereRaw[$i] = $searchFields[$i] . ' = ' . "'$stringLike'";
                }
        }

        if (!empty($whereRaw))

            $query->whereRaw(implode(' and ', $whereRaw));

        $total = $query->get()->count();
        //pagination
        $page = $params['page'] ?? null;
        $limit = $params['limit'] ?? null;

        if (!empty($limit) && !empty($page)) {
            $offset = ($page - 1) * $limit;
            $query->limit($limit)->offset($offset);
        }

        //get
        $order = $query
            ->join('users', 'orders.id_user', '=', 'users.id')
            ->with(
                [
                    'address:id,full_name,phone,address,id_user',
                    'user:id,name,phone,email',
                    'user.avatar:id,url',
                    'orderDetails:id_order,id_product,quantity',
                    'products:id,name,price,total,description,slug,short_description,serial_number,warranty_period',
                    'products.images:id,url',

                ]
            )
            ->select(
                'orders.id',
                'orders.id_user',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
                'users.name as name_user',
                'orders.id_address',


            )
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
