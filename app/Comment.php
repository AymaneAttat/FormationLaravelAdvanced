<?php

namespace App;

use App\Scopes\LatestScope;
use App\Scopes\AdminShowDeleteScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;  //the best method of suppression (soft delete)

    protected $fillable = ['content','post_id','user_id'];
    
    public function post(){
        return $this->belongsTo('App\Post');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function tags(){
        return $this->morphToMany('App\Tag', 'taggable')->withTimestamps(); //->as('tagged') change name of pivot to tagged
    }

    public function scopeDernier(Builder $query){
        return $query->orderBy(static::UPDATED_AT, 'desc');
    }

    public static function boot(){
        static::addGlobalScope(new AdminShowDeleteScope);
        parent::boot();
        static::addGlobalScope(new LatestScope);
        /*because i'm using observer CommentObserver.php
        static::creating(function(Comment $comment){    Cache::forget("post-show-{$comment->commentable->id}");            });
        */
    }
}
