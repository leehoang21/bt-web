<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    use HasFactory;


    protected $fillable = [
        'id_user',
        'status',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'id_order', 'id_product');
    }


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'id_order');
    }

    public function total()
    {
        $total = 0;
        foreach ($this->orderDetails as $orderDetail) {
            $total += $orderDetail->total();
        }
        return $total;
    }



}
