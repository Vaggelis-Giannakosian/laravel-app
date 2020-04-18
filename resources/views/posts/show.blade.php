@extends('layout')



@section('content')

    <div class="row">

        <div class="col-8">

            <h1>{{ $post->title }}</h1>

            <x-badge
                type="primary"
                message="New Post!"
                :show="now()->diffInMinutes($post->created_at) < 50"
            />


            <p>{{ $post->content }}</p>

            <x-updated :date="$post->created_at" :name="$post->user->name" />
            <x-updated :date="$post->updated_at" type="Updated "/>


            <x-tags :tags="$post->tags"/>

            <p>Currently read by {{ $counter }} people</p>

            <h4>Comments</h4>

            @include('comments._form')

            @forelse($comments as $comment)
                <p>{{$comment->content}}</p>
                <p class="text-muted">
                    <x-updated :date="$comment->created_at" :name="$comment->user->name" />
            @empty
                <p>No comments yet!</p>
            @endforelse

        </div>


    <div class="col-4">
        @include('posts._activity')
    </div>



@endsection
