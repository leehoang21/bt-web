<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'detail',
        'news_id',
        'e_title',
        'e_detail',
    ];
}