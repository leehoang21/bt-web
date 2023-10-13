<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    use HasFactory;

    protected $fillable = [

        'id',
        'user_name',
        'password',
        'type',
        'full_name',
        'address',
        'phone',
        'mail',
        'is_enable',
        'e_full_name',
        'e_address',
    ];


}