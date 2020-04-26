@extends('layout')



@section('content')

    <div class="row">
        <div class="col-8">
            @forelse($posts as $post)
                <div class="mb-4">


                    <h3>

                        @if($post->trashed())
                            <del>
                                @endif
                                <a class="{{ $post->trashed() ? 'text-muted' : '' }}"
                                   href="{{ route('posts.show',['post'=>$post->id]) }}">{{ $post->title }}</a>
                                @if($post->trashed())
                            </del>
                        @endif
                    </h3>

                    <x-updated :date="$post->created_at" :name="$post->user->name" :userId="$post->user->id"/>

                    <x-tags :tags="$post->tags"/>

                    <p>{{ trans_choice('messages.comments', $post->comments->count()) }}</p>


                    @auth
                        @can('update', $post)
                            <a class="btn btn-primary btn-sm"
                               href="{{ route('posts.edit',['post'=>$post->id]) }}">Edit</a>
                        @endcan
                    @endauth


                    @if(!$post->trashed())
                        @auth
                            @can('delete', $post)
                                <form class="fm-inline" action="{{ route('posts.destroy',['post'=>$post->id]) }}"
                                      method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">DELETE</button>
                                </form>
                            @endcan
                        @endauth
                    @endif


                </div>
            @empty
                <p>No blog posts yet!</p>
            @endforelse
        </div>

        <div class="col-4">
                @include('posts._activity')
        </div>

    </div>


@endsection
