@forelse($comments as $comment)
    <p>{{$comment->content}}</p>
    <p class="text-muted">
        <x-updated :date="$comment->created_at" :name="$comment->user->name" :userId="$comment->user->id"/>
@empty
    <p>No comments yet!</p>
@endforelse
