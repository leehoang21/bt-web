<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;


    protected $fillable = [
        'id_user',
        'id_product',
        'quantity',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function avatar()
    {
        return $this->belongsToMany(Avatar::class, 'users', 'id_user', 'id_avatar');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'id_order', 'id_product');
    }

}
