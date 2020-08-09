<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Mail\CommentPosted;
use Illuminate\Http\Request;
use App\Mail\CommentedPostMarkdown;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\CommentResource;
use App\Jobs\NotifyUsersPostWasCommented;
use App\Events\CommentPosted as MyCommentPosted;

class PostCommentController extends Controller
{
    //public function __construct()
    //{
    //    $this->middleware('auth');
    //}

    public function show(Post $post){
        //return $post->with('user')->first();
        //return new CommentResource($post->comments->first());//if you want to inject and transformer one comment
        //this method is counting on leazy method return CommentResource::collection($post->comments);//if you want to inject and transformer list of comments
        return CommentResource::collection($post->comments()->with('user')->get());
    }

    public function store(Request $request, Post $post){ //we can use $id in store function or we can import the Post model, and when i do that laravel automaticaly find the post that we add inside him a comment (compare $post->id that we send in form with Post model) 
        $this->validate($request, [
            'content' => 'bail|min:5|required'
        ]);
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id ]);
        //Mail::to($post->user->email)->send(new CommentPosted($comment));
        //Mail::to($post->user->email)->send(new CommentedPostMarkdown($comment)); first method
        event(new MyCommentPosted($comment));
        /*because i'm using listener NotifyUserAboutComment.php
        Mail::to($post->user->email)->queue(new CommentedPostMarkdown($comment));//second method
        NotifyUsersPostWasCommented::dispatch($comment);
        */
        //$when = now()->addMinutes(1);//third method
        //Mail::to($post->user->email)->later($when , new CommentedPostMarkdown($comment));//third method: he's gonna wait 1min in jobs table
        return \redirect()->back();
    }
}
