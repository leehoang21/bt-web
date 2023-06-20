<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisory extends Model
{
    use HasFactory;

    protected  $table = 'advisories';

    protected $fillable = [
        'phone',
        'name',
        'status',
        'email',
        'content',
    ];

}
