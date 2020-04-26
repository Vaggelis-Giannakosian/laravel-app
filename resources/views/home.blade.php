
@extends('layout')


@section('content')

    <h1>{{ __('Welcome to Laravel!') }}</h1>

    <p>{{ __('messages.example_with_value',['name'=> auth()->user()->name ?? '']) }}</p>

    <p>{{ __('Hello :name',['name'=> auth()->user()->name ?? '']) }}</p>
    <p>This is the content of the main page!</p>

@endsection

