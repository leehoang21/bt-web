<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_image',
        'id_product',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'id_image');
    }


}
