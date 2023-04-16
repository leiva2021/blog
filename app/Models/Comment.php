<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'post_id',
        'user_id',
    ];

    // * Indica que cada comentario le pertence a un solo post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // * indica que un comentario pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
