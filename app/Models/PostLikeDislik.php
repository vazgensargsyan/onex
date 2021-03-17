<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLikeDislik extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'like_vs',
        'dislike',
    ];
}
