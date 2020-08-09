<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Http\ViewComposers\ActivityComposer;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'archive', 'all', 'show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$mostComments = Cache::remember('mostComments', now()->addSeconds(15), function(){
            return Post::mostCommented()->take(5)->get();
        });
        $mostUsersActive = Cache::remember('mostUsersActive', now()->addSeconds(15), function(){
            return User::usersActive()->take(5)->get();
        });
        $mostUsersActiveLastMonth = Cache::remember('mostUsersActiveLastMonth', now()->addSeconds(15), function(){
            return User::userActiveInLastMonth()->take(5)->get();
        }); */
        //->orderBy('updated_at', 'desc') 
        $posts = Post::postWithUserCommentsTags()->get();
        /*$mostComments = $mostComments;
        $mostUsersActive = $mostUsersActive;
        $mostUsersActiveLastMonth = $mostUsersActiveLastMonth; */
        //$mostComments = Post::mostCommented()->take(5)->get();
        //$mostUsersActive = User::usersActive()->take(5)->get();
        //$mostUsersActiveLastMonth = User::userActiveInLastMonth()->take(5)->get();   'mostComments', 'mostUsersActiveLastMonth', 'mostUsersActive',
        $tab = "list";
        return view('posts.index', compact('posts', 'tab'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function archive()
    {
        $posts = Post::onlyTrashed()->withCount('comments')->with('user')->get();
        $mostComments = Post::mostCommented()->take(5)->get();
        $mostUsersActive = User::usersActive()->take(5)->get();
        $mostUsersActiveLastMonth = User::userActiveInLastMonth()->take(5)->get();
        $tab = "archive";
        return view('posts.index', compact('posts', 'mostComments', 'mostUsersActiveLastMonth', 'mostUsersActive', 'tab'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function all()
    {
        //->orderBy('updated_at', 'desc')
        $posts = Post::withTrashed()->withCount('comments')->get();
        $tab = "all";
        return view('posts.index', compact('posts', 'tab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$this->authorize("post.create");//we don't need post. when we use policies array
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|bail',
            'content' => 'bail|min:3|required',
            'picture' => 'image|mimes:jpeg,jpg,png,gif,svg' // |max:1024|dimensions:min_height=500
        ]);
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->slug = Str::slug($post->title, '-');
        $post->active = false;
        $post->user_id = Auth()->user()->id;
        $post->save();
        if($request->hasFile('picture')){//Upload picture for current Post
            $path = $request->file('picture')->store('posts');
            $image = new Image(['path' => $path]); //or $post->image()->save(Image::make(['path' => $path]))
            $post->image()->save($image);
        }
        $request->session()->flash('status', 'Post Created');
        return redirect()->route('posts.index');
        /* return redirect()->route('posts.show', ['post' => $post->id]); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $postShow = Cache::remember("post-show-{$id}", now()->addSeconds(60), function() use($id) {
            return Post::with(['comments','tags' ,'comments.user'])->findOrFail($id);//eager method
        });
        $post = $postShow;
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        //if( Gate::denies('post.update', $post) ){ //if denies return true <=> n'a pas autorisation
        //    abort(403, "You can't edit this post !"); //it's can't edit this post
        //};
        $this->authorize("update", $post);//we don't need post. when we use policies array
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'bail|required',
            'content' => 'required',
            'picture' => 'image|mimes:jpeg,jpg,png,gif,svg' // |max:1024|dimensions:min_height=500
        ]);
        $post = Post::findOrFail($id);
        //if( Gate::denies('post.update', $post) ){ //if denies return true <=> n'a pas autorisation
        //    abort(403, "You can't edit this post !"); //it's can't edit this post
        //};
        $this->authorize("update", $post);//we don't need post. when we use policies array
        if($request->hasFile('picture')){//Upload picture for current Post
            $path = $request->file('picture')->store('posts');
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }else{
                $post->image->save(Image::make(['path' => $path]));
            }
            $image = new Image(['path' => $path]);
            $post->image()->save($image);
        }
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->slug = Str::slug($post->title, '-');
        $post->save();
        $request->session()->flash('status', 'Post Updated');
        return redirect()->route('posts.show', $post->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        //$this->authorize("post.delete", $post);//or you can use Gate::denies()
        $this->authorize("delete", $post);//we don't need post. when we use policies array
        $post->delete();
        return redirect()->route('posts.index');
    }

    public function restore($id){
        $post = Post::onlyTrashed()->where('id', $id)->first();
        $post->restore();
        return redirect()->back();
    }

    public function forcedelete($id){
        $post = Post::onlyTrashed()->where('id', $id)->first();
        $post->forceDelete();//supprimer physiquement le post
        return redirect()->back();
    }
}
