<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_product',
        'id_tag',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'id_tag');
    }



}
