@extends('layout')



@section('content')

    @forelse($posts as $post)
        <div>
          <h3>
              <a href="{{ route('posts.show',['post'=>$post->id]) }}" >{{ $post->title }}</a>
          </h3>

            <a href="{{ route('posts.edit',['post'=>$post->id]) }}">Edit</a>

            <p>{{ $post->content }}</p>
        </div>
    @empty
        <p>No blog posts yet!</p>
    @endforelse

@endsection
