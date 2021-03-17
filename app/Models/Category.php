<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoryParent;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sort',
    ];

    public function parent_ids(){
        return $this->hasMany('App\Models\CategoryParent', 'category_id', 'id');
    }
}
