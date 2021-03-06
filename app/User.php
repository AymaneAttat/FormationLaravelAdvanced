<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public const LOCALES = [
        'en' => 'English',
        'ar' => 'عربية',
        'fr' => 'Français' ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany('App\Post');
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable')->dernier();
    }

    public function image(){
        return $this->morphOne('App\Image', 'imageable');
    }

    public function scopeUsersActive(Builder $query){
        return $query->withCount('posts')->orderBy('posts_count', 'desc');
    }

    public function scopeUserActiveInLastMonth(Builder $query){
        return $query->withCount(['posts' => function(Builder $query){
            $query->whereBetween(static::CREATED_AT, [now()->subMonths(1), now()]);
        }])->having('posts_count' , '>', 1)
        ->orderBy('posts_count', 'desc');
    }
}
