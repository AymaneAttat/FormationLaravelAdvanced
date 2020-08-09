<?php

namespace App;

use App\Scopes\LatestScope;
use App\Scopes\AdminShowDeleteScope;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;  //the best method of suppression (soft delete)
    
    protected $fillable = ['title', 'content', 'slug', 'active', 'user_id'];
    
    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->dernier();
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    //public function image(){ return this->hasOne('App\Image'); }

    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }

    public function tags(){
        return $this->morphToMany('App\Tag', 'taggable')->withTimestamps(); //->as('tagged') change name of pivot to tagged
    }

    public function scopeMostCommented(Builder $query){
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }

    public function scopePostWithUserCommentsTags(Builder $query){
        return $query->withCount('comments')->with(['user','tags','image']);
    }
    
    //second method, third method is use onDelete('cascade') in migration file but this is a physique suppression, first method is use SoftDelete
    public static function boot(){
        static::addGlobalScope(new AdminShowDeleteScope);
        parent::boot();
        
        static::addGlobalScope(new LatestScope);
        /*because i'm using observer (PostObserver.php)
        static::deleting(function(Post $post){    $post->comments()->delete(); });
        static::updating(function(Post $post){    Cache::forget("post-show-{$post->id}");    });
        static::restoring(function(Post $post){    $post->comments()->restore();    });
        */
    }
}