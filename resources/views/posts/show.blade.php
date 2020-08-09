@extends('layouts.dark')
@section('content')
<div class="row">
    <div class="col-8">
        <div class="container">
            <h1>{{ $post->title }}</h1>
            @if($post->image)<img src="{{$post->image->url()}}" class="mt-3 img-fluid rounded" alt="">@endif
            <h3><p>{{ $post->content }}</p></h3>
            <!-- include('comments.form', [$post->id]) -->
            <x-comment-form :action="route('posts.comments.store', $post->id)"></x-comment-form>
            <x-tags :tags="$post->tags"></x-tags>
            <!-- <p>Added  $ post->created_at->diffForHumans() }} </p> -->
            <x-updated :date="$post->created_at" :name="$post->user->name"></x-updated>
            <h4>Comments</h4>
            <x-comment-list :comments="$post->comments"></x-comment-list>
        </div>
    </div>
    <div class="col-4">
        @include('posts.sidebar')
    </div>
</div>
@endsection