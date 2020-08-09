@forelse ($comments as $comment)
    <p>{{ $comment->content }}</p>
    <p class="text-muted"><x-updated :date="$comment->created_at" :name="$comment->user->name"></x-updated></p> <!-- <p class="text-muted">Added  comment->created_at->diffForHumans() }}</p> -->
@empty
    <p>{{__('no comments yet !')}}</p>
@endforelse