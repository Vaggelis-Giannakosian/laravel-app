@extends('layout')


@section('content')

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

       @include('posts._form')

        <button class="btn btn-primary" type="submit">Create</button>
    </form>

@endsection
