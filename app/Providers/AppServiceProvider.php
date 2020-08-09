<?php

namespace App\Providers;

use App\Post;
use App\Comment;
use App\Observers\PostObserver;
use App\Observers\CommentObserver;
use Illuminate\Support\ServiceProvider;
use App\Http\Resources\CommentResource;
use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \view()->composer(['posts.sidebar'], ActivityComposer::class);
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);
        //CommentResource::withoutWrapping();//just for resource of comment
        JsonResource::withoutWrapping();//for all resource
    }
}
