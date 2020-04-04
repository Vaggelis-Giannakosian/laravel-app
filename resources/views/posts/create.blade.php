@extends('layout')


@section('content')

    <form action="{{ route('posts.store') }}" method="POST">

        @csrf

        <p>
            <label for="title">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
        </p>

        @error('title')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror


        <p>
            <label for="content">Content</label>
            <textarea name="content" id="content" cols="30" rows="10"
                      placeholder="Write the content here...">{{ old('content') }}</textarea>
        </p>

        @error('content')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror


        @if($errors->any())
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <button type="submit">Create!</button>

    </form>

@endsection
