<?php

namespace App\Main\DTO;

use App\Models\Product;

class ProductDTO
{
    protected ?Product $product;
    public function __construct($product)
    {
        $this->product = $product;
    }

    public function formatData() {
        $item = $this->product;

        return $item;
    }



    public function formatDataDetailProduct() {
        $item = $this->product;
        return $item;
    }

}
