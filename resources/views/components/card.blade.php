<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title">{{ __($title) }}</h4>
        <p class="text-muted">{{ __($text) }}</p>
    </div>
    <ul class="list-group list-group-flush">
        @if(empty(trim($slot)))
            @forelse ($items as $key => $item)
                <li class="list-group-item">
                    <span class="badge badge-{{$type ?? 'success'}}"> {{ $count[$key] }}</span>{{ $item }}
                </li>
            @empty
                <li class="list-group-item">{{__('No post at this moment!')}}</li>
            @endforelse
        @else
            {{ $slot }}
        @endif
    </ul>
</div>