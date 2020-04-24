<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<p>Hi {{ $comment->commentable->user->name }}</p>

<p>
    Someone has commented on your Blog Post
    <a href="{{ route('posts.show',[ 'post'=> $comment->commentable_id  ]) }}">
        {{ $comment->commentable->title }}
    </a>
</p>

<hr>

<p>
    <img src="{{ $message->embed( $comment->user->thumb->url() ) }}" alt="">

    <a href="{{ route('users.show', [ 'user' => $comment->user_id]) }}">
        {{ $comment->user->name }}
    </a> said:
</p>


<p>
    "{{ $comment->content }}"
</p>
