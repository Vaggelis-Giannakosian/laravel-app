@extends('layout')



@section('content')

    @foreach($posts as $post)
        <a href="{{ route('posts.show',$post->id) }}" target="_blank"><h1>{{ $post->title }}</h1></a>
        <p>{{ $post->content }}</p>
    @endforeach

@endsection
