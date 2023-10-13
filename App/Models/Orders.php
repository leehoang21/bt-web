<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'decription',
        'status',
        'created_date',
        'processed_date',
        'e_decription',
        'e_title',
        'customer_id',
        'employee_id',
    ];
}