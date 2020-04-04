@extends('layout')



@section('content')

    @forelse($posts as $post)
        <div class="mb-4">
          <h3>
              <a href="{{ route('posts.show',['post'=>$post->id]) }}" >{{ $post->title }}</a>
          </h3>

            <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',['post'=>$post->id]) }}" >Edit</a>
            <form class="fm-inline" action="{{ route('posts.destroy',['post'=>$post->id]) }}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-primary btn-sm">DELETE</button>
            </form>
        </div>
    @empty
        <p>No blog posts yet!</p>
    @endforelse

@endsection
