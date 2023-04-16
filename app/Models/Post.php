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
        'url',
        'category_id',
        'user_id'
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    // * Relacion muchos a uno, indica que un post puede tener muchos comentarios
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
