@extends('layout')


@section('content')
    <form class="form-horizontal" action="{{ route('users.update',['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf

        @include('users._form')

    </form>
@endsection
