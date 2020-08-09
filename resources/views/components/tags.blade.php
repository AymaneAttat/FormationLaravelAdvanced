@foreach ($tags as $tag)
    <span class="badge badge-info"><a style="color: white;" href=" {{route('posts.tag.index', $tag->id)}} "> {{$tag->name}}</a></span>
@endforeach