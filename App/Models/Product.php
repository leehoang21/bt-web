<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'short_description',
        'slug',
        'description',
        'price',
        'id_category',
        'status',
        'total',
        'serial_number',
        'warranty_period',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, 'image_products', 'id_product', 'id_image');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'id_product', 'id_order');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'id_product', 'id_tag');
    }


}
