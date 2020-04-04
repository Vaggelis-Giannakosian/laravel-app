@extends('layout')



@section('content')

    @forelse($posts as $post)
        <div>
          <h3>
              <a href="{{ route('posts.show',['post'=>$post->id]) }}" >{{ $post->title }}</a>
          </h3>

            <a class="btn btn-primary" href="{{ route('posts.edit',['post'=>$post->id]) }}" >Edit</a>
            <form class="fm-inline" action="{{ route('posts.destroy',['post'=>$post->id]) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-primary">DELETE</button>
            </form>
            <p>{{ $post->content }}</p>
        </div>
    @empty
        <p>No blog posts yet!</p>
    @endforelse

@endsection
