@extends('layout')



@section('content')

    <div class="row">

        <div class="col-4">
            <img src="{{ $user->thumb ? $user->thumb->url() : '' }}" alt="" class="img-thumbnail img-fluid avatar">
        </div>

        <div class="col-8">

         <h3>  {{ $user->name }}  </h3>

            <p>{{ trans_choice('messages.people.reading',$counter) }}</p>

            <h4>Comments</h4>

            <x-comment-form :route="route('users.comments.store', ['user'=>$user->id])"/>

            <x-comment-list :comments="$user->commentsOn"/>

        </div>

    </div>


@endsection
