@extends('layout')


@section('content')

    <form action="{{ route('posts.store') }}" method="POST">

@csrf

        <p>
            <label for="title">Title</label>
            <input type="text" name="title" id="title">
        </p>

        <p>
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10" placeholder="Write the content here..."></textarea>
        </p>

        <button type="submit">Create!</button>

    </form>

@endsection
