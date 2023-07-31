<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'address',
    ];

    protected $table = 'user_addresses';

    public function user()
    {
        return $this->hasMany(User::class, 'user_addresses', 'id_user');
    }

}
