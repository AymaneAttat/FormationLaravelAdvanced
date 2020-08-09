@component('mail::message')
# Introduction

SomeOne has comment your post

[Laravel advanced](https://google.com)

The body of your message.

@component('mail::button', ['url' =>  route('posts.show', ['post' => $comment->commentable->id])  ])
Button Text
@endcomponent

@component('mail::button', ['url' =>  route('users.show', ['user' => $comment->user->id])  ])
{{$comment->user->name}} Profile
@endcomponent

@component('mail::panel')
{{$comment->content}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
