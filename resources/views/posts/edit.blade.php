@extends('layout')


@section('content')
    <form action="{{ route('posts.update',['post'=>$post->id]) }}" method="PUT">

        @csrf

        <p>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ $post->title }}">
        </p>

        <p>
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10" placeholder="Write the content here...">{{ $post->content }}</textarea>
        </p>

        <button type="submit">Update!</button>

    </form>
@endsection