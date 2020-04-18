<div class="mb-2 mt-2">
    @auth
        <form action="{{ route('posts.comments.store', ['post'=>$post->id]) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea class="form-control" name="content" id="content"></textarea>
            </div>

            <x-errors name="content"/>

            <button class="btn btn-primary" type="submit">Add comment</button>

        </form>
    @else
        <a href="{{ route('login') }}">Sign in</a> to post comments!
    @endauth
</div>

<hr>
