<?php

namespace App\Main\DTO;

use App\Models\Advisory;

class AdvisoryDTO
{
    protected Advisory $dto;
    public function __construct($dto)
    {
        $this->dto = $dto;
    }

    public function formatData() {
        $item = $this->dto;

        return $item;
    }



}
