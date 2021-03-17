<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'photo',
    ];

    public function category_ids(){
        return $this->hasMany('App\Models\PostToCategory', 'post_id', 'id');
    }

    public function like_dislike(){
        return $this->hasOne('App\Models\PostLikeDisLik', 'post_id', 'id')->where('user_id', Auth::user()->id);
    }

    public function likeDislikes(){
        return $this->hasMany('App\Models\PostLikeDisLik', 'post_id', 'id');
    }

    public function comments(){
        return $this->hasMany('App\Models\PostComment', 'post_id', 'id');
    }
}
