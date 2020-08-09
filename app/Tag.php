<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function posts(){
        return $this->morphedByMany('App\Post', 'taggable')->withTimestamps();//->as('posted') change name of pivot to posted
    }

    public function comments(){
        return $this->morphedByMany('App\Comment', 'taggable')->withTimestamps();
    }
}
