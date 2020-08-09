@if(session()->has('status'))
    <div class="alert alert-info"><strong>Info: </strong> {{session()->get('status')}} </div>
@endif