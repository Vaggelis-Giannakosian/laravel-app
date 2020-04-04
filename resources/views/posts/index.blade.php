@extends('layout')



@section('content')

    @forelse($posts as $post)
        <div>
          <h1>  <a href="{{ route('posts.show',['post'=>$post->id]) }}" target="_blank">{{ $post->title }}</a>&emsp;<a href="{{ route('posts.edit',['post'=>$post->id]) }}">Edit</a></h1>
            <p>{{ $post->content }}</p>
        </div>
    @empty
        <p>No blog posts yet!</p>
    @endforelse

@endsection
