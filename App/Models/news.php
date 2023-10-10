<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'title',
        'short_content',
        'detail_content',
        'image',
        'e_title',
        'e_short_content',
        'e_detail_content',
        'cat_new_id',
    ];
}