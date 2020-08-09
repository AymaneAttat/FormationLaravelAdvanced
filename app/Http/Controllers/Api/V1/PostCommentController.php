<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\CommentResource;
use App\Http\Controllers\Controller;
use App\Events\CommentPosted;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Comment;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Post $post, Request $request)
    {
        $perPage = $request->input('per_page') ?? null;
        return CommentResource::collection($post->comments()->with('user')->paginate($perPage)->appends([
            'per_page' => $perPage
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $this->validate($request, [
            'content' => 'min:5|required'
        ]); 
        $comment = $post->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id ]);
        event(new CommentPosted($comment));
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post,Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post, Request $request, Comment $comment)
    {
        $comment->content = $request->content;
        $comment->save();
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post,Comment $comment)
    {
        $comment->delete();
        return \response()->noContent();
    }
}
