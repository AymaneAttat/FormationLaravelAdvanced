<div class="text-muted">
    {{ empty(trim($slot)) ? __('Added') : $slot }} {{ $date->diffForHumans()}}
    {!! isset($name) ? ', '. __('by') .'<a href='. url('users',$userId) .'>'.$name . '</a>' : null !!}
</div>