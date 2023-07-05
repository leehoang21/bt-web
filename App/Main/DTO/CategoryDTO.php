<?php

namespace App\Main\DTO;

use App\Models\Category;

class CategoryDTO
{
    protected ?Category $dto;
    public function __construct($dto)
    {
        $this->dto = $dto;
    }

    public function formatData() {
        $item = $this->dto;

        return $item;
    }



}
