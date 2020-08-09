@extends('layouts.dark')
@section('content')
<div class="row">
    <div class="col-8">
        <div class="container">
            <!--
            <nav class="nav nav-tabs nav-stacked my-5">
                <a class="nav-link @if($tab == 'list') active @endif" href="/posts">List</a>
                <a class="nav-link @if($tab == 'archive') active @endif" href="/posts/archive">Archive</a>
                <a class="nav-link @if($tab == 'all') active @endif" href="/posts/all">All</a>
            </nav> -->
            <div class="mx-3">
                <h4>{{ $posts->count() }} {{__('Posts')}}</h4>
            </div>
            <h2>{{__('List of posts')}}</h2>
            <ul>
                @forelse ($posts as $post)
                    <li>
                        @if($post->created_at->diffInHours() < 1)
                            <x-badge type="success">{{__('New')}}</x-badge><!-- component('partials.badge', ['type' => 'success'])    New endcomponent -->
                        @else
                            <x-badge type="light">{{__('Old')}}</x-badge><!-- component('partials.badge', ['type' => 'dark'])    Old endcomponent -->
                        @endif
                        <x-updated :date="$post->created_at" :name="$post->user->name" :userId="$post->user"></x-updated><!-- <em>{ $post->created_at->diffForHumans() }}</em> -->
                        <!-- First best method <img src=" Storage::url($post->image->path ?? null)}} " class="mt-3 img-fluid roundred" alt=""> -->
                        @if($post->image)<img src="{{$post->image->url()}}" class="mt-3 img-fluid rounded" alt="">@endif
                        <h2><a href="{{ route('posts.show', ['post' => $post->id]) }}">
                            @if($post->trashed())
                                <del>{{ $post->title }}</del>
                            @else
                                {{ $post->title }}
                            @endif
                        </a></h2>
                        <!-- include('comments.form') -->
                        <x-tags :tags="$post->tags"></x-tags>
                        <x-updated :date="$post->updated_at" >{{__('Updated')}} </x-updated> <!-- :name="$post->user->name" -->
                        @if($post->comments_count)
                            <div><span class="badge badge-success">{{ $post->comments_count }} {{__('comments')}}</span><br>
                                <!-- <p class="text-muted"> { $post->updated_at->diffForHumans()}} by {$post->user->name}} </p> -->
                                @auth
                                    <div class="btn-group">
                                        @if(!$post->deleted_at)
                                            {!! Form::open(['action' => ['PostController@destroy', $post->id], 'methode' => 'POST']) !!}
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    @can('update', $post)<a class="btn btn-lg btn-circle btn-outline-primary" href="{{ route('posts.edit',$post->id) }}"> {{__('Modifier')}} </a>@endcan
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    @can('delete', $post)<button type="submit" class="btn btn-lg btn-circle btn-outline-danger" value="Supprimer">{{__('Supprimer')}}</button>@endcan
                                                </div>
                                            {!! Form::close() !!}
                                        @else
                                            <form method="POST" class="fm-inline" action="{{ url('/posts/'.$post->id.'/restore') }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    @can('update', $post)<a class="btn btn-lg btn-circle btn-outline-secondary" href="{{ route('posts.edit',$post->id) }}">{{__('Modifier')}}</a>@endcan
                                                    @can('restore', $post)<button type="submit" class="btn btn-lg btn-circle btn-outline-success">{{__('Restore!')}}</button>@endcan
                                                </div>
                                            </form>
                                            @can('forceDelete', $post)
                                                <form method="POST" class="fm-inline" action="{{ url('/posts/'.$post->id.'/forcedelete') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="form-group">   
                                                        <button type="submit" class="btn btn-lg btn-circle btn-outline-danger"> {{__('Force Delete!')}} </button>
                                                    </div>
                                                </form>  
                                            @endcan
                                        @endif
                                    </div>
                                    @cannot('delete', $post)
                                        @component('partials.badge', ['type' => 'danger'])
                                            {{__("You can't delete this post!")}}
                                        @endcomponent
                                    @endcannot
                                @endauth
                                
                            </div>
                        @else 
                            <div>
                                @component('partials.badge', ['type' => 'dark'])
                                    {{__('no comments yet !')}}
                                @endcomponent<br>
                                @auth
                                    <div class="btn-group">
                                        @if(!$post->deleted_at)
                                            {!! Form::open(['action' => ['PostController@destroy', $post->id], 'methode' => 'POST']) !!}
                                                {!! csrf_field() !!}
                                                <div class="form-group">
                                                    @can('update', $post)<a class="btn btn-lg btn-circle btn-outline-primary" href="{{ route('posts.edit',$post->id) }}"> {{__('Modifier')}} </a>@endcan
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    @can('delete', $post)<button type="submit" class="btn btn-lg btn-circle btn-outline-danger" value="Supprimer">{{__('Supprimer')}}</button>@endcan
                                                </div>
                                            {!! Form::close() !!}
                                        @else 
                                            <form method="POST" class="fm-inline" action="{{ url('/posts/'.$post->id.'/restore') }}">
                                                @csrf
                                                @method('PATCH')
                                                <div class="form-group">
                                                    @can('update', $post)<a class="btn btn-lg btn-circle btn-outline-secondary" href="{{ route('posts.edit',$post->id) }}"> {{__('Modifier')}} </a>@endcan
                                                    @can('restore', $post)<button type="submit" class="btn btn-lg btn-circle btn-outline-success">{{__('Restore!')}}</button>@endcan
                                                </div>
                                            </form>
                                            @can('forceDelete', $post)
                                                <form method="POST" class="fm-inline" action="{{ url('/posts/'.$post->id.'/forcedelete') }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="form-group">   
                                                        <button type="submit" class="btn btn-lg btn-circle btn-outline-danger"> {{__('Force Delete!')}} </button>
                                                    </div>
                                                </form>  
                                            @endcan
                                        @endif
                                    </div>
                                    @cannot('delete', $post)
                                        @component('partials.badge', ['type' => 'danger'])
                                            {{__("You can't delete this post!")}}
                                        @endcomponent
                                    @endcannot 
                                @endauth            
                            </div>
                        @endif
                    </li>
                @empty
                    <p class="text-muted">{{__('No post at this moment!')}}</p>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="col-4">
        <br><br>
        @include('posts.sidebar')
    </div>
</div>
@endsection