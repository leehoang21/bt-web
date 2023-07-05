<?php

namespace App\Main\DTO;

use App\Models\Category;
use App\Models\Image;

class ImageDTO
{
    protected ?Image $dto;
    public function __construct($dto)
    {
        $this->dto = $dto;
    }

    public function formatData() {
        $item = $this->dto;

        return $item;
    }



}
