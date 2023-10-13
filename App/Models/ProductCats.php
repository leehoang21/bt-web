<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCats extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'e_name',
        'quantity',
        'image',
    ];
}