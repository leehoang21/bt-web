<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCats extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'decription',
        'image',
        'e_name',
        'e_decription',
    ];
}