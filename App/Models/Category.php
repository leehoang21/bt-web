<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'image_categories', 'id_category', 'id_image');
    }


}
