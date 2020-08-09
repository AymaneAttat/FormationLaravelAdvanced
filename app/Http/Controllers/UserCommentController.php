<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, User $user){ //we can use $id in store function or we can import the Post model, and when i do that laravel automaticaly find the post that we add inside him a comment (compare $post->id that we send in form with Post model) 
        $this->validate($request, [
            'content' => 'bail|min:5|required'
        ]);
        $user->comments()->create([
            'content' => $request->content,
            'user_id' => $request->user()->id ]);
        return \redirect()->back()->withStatus('Comment Created');
    }
}
