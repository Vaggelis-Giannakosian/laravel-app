@extends('layout')



@section('content')

    <h1>{{ $post->title }}</h1>

        <x-badge
            type="primary"
            message="New Post!"
            :show="now()->diffInMinutes($post->created_at) < 50"
        />


    <p>{{ $post->content }}</p>

    <x-updated :date="$post->created_at" :name="$post->user->name" />

    <h4>Comments</h4>
    @forelse($comments as $comment)
        <p>{{$comment->content}}</p>
        <p class="text-muted">
            <x-updated :date="$comment->created_at" :name="$comment->user->name" />
    @empty
        <p>No comments yet!</p>
    @endforelse

@endsection
