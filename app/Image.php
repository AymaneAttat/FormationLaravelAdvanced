<?php

namespace App;

use App\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path'];

    //public function post(){
    //    return $this->belongsTo('App\Post');}

    public function imageable(){
        return $this->morphTo();
    }

    public function url(){
        return Storage::url($this->path);
    }
}
