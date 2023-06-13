<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_post',
        'id_tag',
    ];

    public function post()
    {
        return $this->belongsTo(Product::class, 'id_post');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'id_tag');
    }



}
