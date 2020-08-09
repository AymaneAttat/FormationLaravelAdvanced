@auth
    <h5>{{__('Add comment')}}</h5>
    <form action=" {{$action}} " method="POST">
        @csrf
        <div class="form-group">
            <textarea name="content" rows="3" class="form-control my-3"></textarea>
        </div>
        <x-errors></x-errors>
        <div class="form-group">
            <button class="btn btn-primary btn-block">{{__('Create')}}</button>
        </div>
    </form>
@else
    <a href="" class="btn btn-success btn-sm">{{__('Sign In')}}</a> {{__('to post comments!')}}
@endauth