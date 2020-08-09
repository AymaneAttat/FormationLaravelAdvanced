@extends('layouts.dark')
@section('content')
<br>
    <div class="container">
        <h1>Update Post</h1>
        {!! Form::open(['action' => ['PostController@update', $post->id], 'methode' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {!! csrf_field() !!}
            <div class="form-group">
                {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title', 'required data-error' => 'Please enter your title'])}}
            </div>
            <div class="form-group">
                {{Form::text('content', $post->content, ['class' => 'form-control', 'placeholder' => 'Content', 'required data-error' => 'Please enter your content'])}}
            </div>
            <div class="form-group">
                <div class="row">
                    {{Form::label('picture', 'Picture', ['class' => 'col-1'])}}
                    <div class="col-md-4">{{Form::file('picture',['class' => 'form-control-file'])}}</div>
                </div>
            </div>
            <div class="form-group">
                {{Form::hidden('_method','PUT')}}
                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}} 
                <div class ="float-right"><a href="{{ route('posts.index') }}" class="btn btn-secondary">Go back</a></div> 
                <div class="clearfix"></div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection