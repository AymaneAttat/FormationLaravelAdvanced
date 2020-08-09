@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><!-- { __('messages.Welcome') }}  this method use lang file --> <!-- or use @ lang('messages.Welcome') -->
                    {{ __('Welcome') }} <!-- this method use json -->
                    {{ __('messages.example_with_value', ['name' => auth()->user()->name]) }}<br> <!-- this method use lang file -->
                    {{ trans_choice('messages.plural',0) }}<br><!-- this method use lang file -->
                    {{ trans_choice('plural',0) }}<!-- this method use json -->
                    @can('secret.page') <p><a href="/secret">Administration</a></p> @endcan
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
