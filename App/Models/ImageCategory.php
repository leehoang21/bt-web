<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ImageCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_image',
        'id_category',
    ];

    protected $primaryKey = 'id_category';

    public function image()
    {
        return $this->belongsTo(Image::class, 'id_image');
    }

}
