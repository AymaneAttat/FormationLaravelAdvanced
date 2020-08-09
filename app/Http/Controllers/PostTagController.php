<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use Illuminate\Http\Request;
use App\Http\ViewComposers\ActivityComposer;

class PostTagController extends Controller
{
    public function index($id){
        $tag = Tag::findOrFail($id);
        $posts = $tag->posts()->postWithUserCommentsTags()->get();
        /*$mostComments = [];   we don't need those any more because we using ActivityComposer  'mostComments','mostUsersActive','mostUsersActiveLastMonth',
        $mostUsersActive = [];  we don't need those any more because we using ActivityComposer
        $mostUsersActiveLastMonth = []; we don't need those any more because we using ActivityComposer */
        $tab = [];
        return view('posts.index', compact('posts','tab'));
    }
}
