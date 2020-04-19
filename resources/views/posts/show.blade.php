@extends('layout')



@section('content')

    <div class="row">

        <div class="col-8">

            @if($post->thumb)
                <div style="background:url('{{ $post->thumb->url() }}');
                    min-height: 500px;
                    color:white;
                    text-align: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;">
                    <h1 style="padding-top:100px; text-shadow: 1px 2px #000;">
                        {{ $post->title }}
                    </h1>
                </div>
            @else
                <h1>{{ $post->title }}</h1>
            @endif


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
