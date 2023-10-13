<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'mail',
        'e_name',
        'e_address',
    ];
}