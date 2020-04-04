@extends('layout')


@section('content')
    <form action="{{ route('posts.update',['post'=>$post->id]) }}" method="POST">
        @method('PUT')

        @csrf
        
        @include('posts._form')

        <button type="submit">Update</button>

    </form>
@endsection
