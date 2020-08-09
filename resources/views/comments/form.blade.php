@auth
    <h5>Add Comment</h5>
    {!! Form::open(['action' => ['PostCommentController@store', $post->id], 'methode' => 'POST']) !!}
        {!! csrf_field() !!}
        <div class="form-group">
            {{Form::textarea('content', '', ['class' => 'form-control', 'placeholder' => 'Your comment','rows' => '3'])}}
        </div>
        <x-errors></x-errors>
        <div class="form-group">
            {{Form::submit('Create', ['class' => 'btn btn-primary btn-block'])}} 
        </div>
    {!! Form::close() !!}
@else
    <a href="" class="btn btn-success btn-sm">Sign In</a> to post a comment!
@endauth