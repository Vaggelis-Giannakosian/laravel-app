@component('mail::message')
# Comment was posted on post you're watching

Hi {{ $user->name }}

@component('mail::button', ['url' => route('posts.show',['post'=>$comment->commentable_id])])
View The Post
@endcomponent

@component('mail::button', ['url' => route('users.show', [ 'user' => $comment->user_id])] )
Visit {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
{{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
