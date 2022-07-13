<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;
    protected  $table= 'dishes';
    protected $filltable = [ 'image','nameFood', 'description', 'price', 'category_id'];
    public function categories(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
