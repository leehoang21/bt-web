<?php

namespace App\Main\DTO;

use App\Models\Tag;

class TagDTO
{
    protected Tag $dto;
    public function __construct($dto)
    {
        $this->dto = $dto;
    }

    public function formatData() {
        $item = $this->dto;

        return $item;
    }



}
