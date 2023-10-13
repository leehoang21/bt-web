<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adverties extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'company_name',
        'address',
        'created_date',
        'web_link',
        'e_title',
        'e_company_name',
        'e_address',
    ];
}