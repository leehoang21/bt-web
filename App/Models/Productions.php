<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productions extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'address',
        'description',
        'phone',
        'mail',
        'image',
        'e_name',
        'e_description',
        'e_address',
    ];
}