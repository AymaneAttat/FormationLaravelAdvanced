<x-card title="Most Post Commented">
    @forelse ($mostComments as $post)
        <li class="list-group-item"><a href="{{ route('posts.show',$post->id) }}">{{ $post->title }}</a>
        <p><span class="badge badge-success">{{ $post->comments_count }}</span></p></li>
    @empty
        <li class="list-group-item">{{__('No post at this moment!')}}</li>
    @endforelse
</x-card>
<x-card title="Most Users" text="Most Users Post Written" :items="collect($mostUsersActive)->pluck('name')" type="info" :count="collect($mostUsersActive)->pluck('posts_count')"></x-card>
<div class="card mt-4">
    <div class="card-body">
        <h4 class="card-title">{{__('Most Users Active')}}</h4><p class="text-muted">{{__('Most Users In Last Month')}}</p>
    </div>
    <ul class="list-group list-group-flush">
        @forelse ($mostUsersActiveLastMonth as $user)
            <li class="list-group-item">
                @component('partials.badge', ['type' => 'info']){{ $user->posts_count }}@endcomponent
                    {{ $user->name }}
            </li>
        @empty
            <li class="list-group-item">{{__('No post at this moment!')}}</li>
        @endforelse
    </ul>
</div>