<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'id_category',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');

    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');

    }

}
