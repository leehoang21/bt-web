<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ImagePost extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_image',
        'id_post',
    ];

    public function image()
    {
        return $this->belongsTo(Image::class, 'id_image');
    }


}
