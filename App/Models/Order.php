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

    public function avatar()
    {
        return $this->belongsToMany(Avatar::class, 'users', 'id_user', 'id_avatar');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'id_order', 'id_product');
    }


    public function orderDetails()
    {
        return $this->hasOne(OrderDetail::class, 'id_order');
    }

    public function totalPrice()
    {
        $total = 0;
        $orderDetails = $this->orderDetails()->where('id_order', $this->id)->get();

        foreach ($orderDetails as $orderDetail) {
            $total += $orderDetail->total();
        }
        return $total;
    }

    public function total()
    {
        $total = 0;
        $orderDetails = $this->orderDetails()->where('id_order', $this->id)->get();
        foreach ($orderDetails as $orderDetail) {
            $total += $orderDetail->quantity;
        }
        return $total;
    }



}
