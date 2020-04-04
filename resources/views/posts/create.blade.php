@extends('layout')


@section('content')

    <form action="{{ route('posts.store') }}" method="POST">

        @csrf

       @include('posts._form')


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
