<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'content',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag', 'id_tag', 'id_product');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'id_tag');
    }

}
