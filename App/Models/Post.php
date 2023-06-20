<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',

    ];

    public function images()
    {
        return $this->belongsToMany(Image::class, 'image_posts', 'id_post', 'id_image');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_posts', 'id_post', 'id_tag');
    }

}
