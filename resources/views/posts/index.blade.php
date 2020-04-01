@extends('layout')



@section('content')

    @forelse($posts as $post)
        <div>
            <a href="{{ route('posts.show',['post'=>$post->id]) }}" target="_blank"><h1>{{ $post->title }}</h1></a>
            <p>{{ $post->content }}</p>
        </div>
    @empty
        <p>No blog posts yet!</p>
    @endforelse

@endsection
