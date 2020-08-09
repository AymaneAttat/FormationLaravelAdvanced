@extends('layouts.dark')
@section('content')
    <div class="container">
        {!! Form::open(['action' => ['UserController@update', $user->id], 'methode' => 'POST', 'enctype' => 'multipart/form-data']) !!}
            {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-4">
                    <h5>{{__('Select a difference Avatar')}}</h5>
                    <img src=" {{$user->image ? $user->image->url() : ''}} " alt="User Image" class="img-thumbnail" style="width: 128px; height:128px;">
                    {{Form::file('avatar',['class' => 'form-control-file'])}}
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        {{Form::label('name', __('Name'), ['class' => 'col-1'])}}
                        {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Your Name'])}} <!-- , 'required data-error' => 'Please enter your title' -->
                    </div>
                    <div class="form-group">
                        {{Form::label('locale', __('Language'), ['class' => 'col-1'])}}
                        <!-- {Form::select('locale', array_pluck( App\User::LOCALES , 'title','id'), $news->category_id, ['class' => 'form-control', 'placeholder' => 'Choose Category']) }} -->
                        <select name="locale" id="Language" class="form-control">
                            @foreach (App\User::LOCALES as $locale => $label)
                                <option value=" {{$locale}} " {{ $user->locale === $locale ? 'selected' : ''}} > {{$label}} </option>
                            @endforeach
                        </select>
                    </div>
                    <x-errors></x-errors>
                    {{Form::hidden('_method','PUT')}}
                    {{Form::submit(__('Upload'), ['class' => 'btn btn-lg btn-circle btn-block btn-outline-warning'])}}
                </div>  
            </div><br>
            <div class ="float-right"><a href="{{ route('posts.index') }}" class="btn btn-secondary">{{__('Go back')}}</a></div>
        {!! Form::close() !!}
    </div>
@endsection