@extends('layouts.dark')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>{{__('Avatar User')}}</h5>
                <img src="{{$user->image ? $user->image->url() : ''}}" alt="" class="img-thumbnail" style="width: 190px; height:190px;">
                @can('update',$user)<a href=" {{route('users.edit', $user->id)}} " class="btn btn-info btn-sm">{{__('Edit')}}</a>@endcan
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <h3>{{$user->name}}</h3>
                    <x-comment-form :action="route('users.comments.store', $user->id)"></x-comment-form>
                </div>
                <hr>
                <x-comment-list :comments="$user->comments"></x-comment-list>
            </div>
        </div>
        <div class ="float-right"><a href="{{ route('posts.index') }}" class="btn btn-secondary">{{__('Go back')}}</a></div>
    </div>
@endsection