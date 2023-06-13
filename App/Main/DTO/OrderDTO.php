<?php

namespace App\Main\DTO;

use App\Models\Order;

class OrderDTO
{
    protected Order $order;
    public function __construct($order)
    {
        $this->order = $order;
    }

    public function formatData() {
        $item = $this->order;

        return $item;
    }


    public function formatDataDetailProduct() {
        $item = $this->order;
        return $item;
    }

}
