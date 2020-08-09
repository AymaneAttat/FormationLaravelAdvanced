@extends('layouts.dark')
@section('content')
<br>
    <div class="container">
        <h1>Create Post</h1>
        {!! Form::open(['action' => 'PostController@store', 'methode' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {!! csrf_field() !!}
            <div class="form-group">
                {{Form::text('title', '', ['class' => 'form-control', 'placeholder' => 'Title'])}} <!-- , 'required data-error' => 'Please enter your title' -->
            </div>
            <div class="form-group">
                {{Form::text('content', '', ['class' => 'form-control', 'placeholder' => 'Content'])}} <!-- , 'required data-error' => 'Please enter your content' -->
            </div>
            <div class="form-group">
                <div class="row">
                    {{Form::label('picture', 'Picture', ['class' => 'col-1'])}}
                    <div class="col-md-4">{{Form::file('picture',['class' => 'form-control-file'])}}</div>
                </div>
            </div>
            <x-errors></x-errors>
            <div class="form-group">
                {{Form::submit('Submit', ['class' => 'btn btn-primary'])}} 
                <div class ="float-right"><a href="{{ route('posts.index') }}" class="btn btn-secondary">Go back</a></div> 
                <div class="clearfix"></div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection