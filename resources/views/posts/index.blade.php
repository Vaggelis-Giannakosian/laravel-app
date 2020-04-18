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

                    <x-updated :date="$post->created_at" :name="$post->user->name"/>

                    <x-tags :tags="$post->tags"/>

                    @if($post->comments_count)
                        <p>{{ $post->comments_count }} comments</p>
                    @else
                        <p>No comments yet!</p>
                    @endif


                    @auth
                        @can('update', $post)
                            <a class="btn btn-primary btn-sm"
                               href="{{ route('posts.edit',['post'=>$post->id]) }}">Edit</a>
                        @endcan
                    @endauth

                    {{--            @cannot('delete',$post)--}}
                    {{--                <p>You cant delete this post.</p>--}}
                    {{--            @endcannot--}}
                    {{--                --}}

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

            <div class="container"></div>

                <div class="row">
                    <?php $mostCommentedArray = $mostCommented->map(function ($el) {
                        return ['title' => $el->title, 'href' => route('posts.show', ['post' => $el->id]), 'count' => $el->comments_count];
                    });?>
                    <x-card title="Most Commented"
                            subtitle="What people are currently talking about"
                            :items="$mostCommentedArray"/>
                </div>


                <div class="row">
                    <?php $mostActiveArray = $mostActive->map(function ($el) {
                        return ['title' => $el->name, 'href' => '', 'count' => $el->posts_count];
                    });?>
                    <x-card title="Most Active Users"
                            subtitle="Writers with most posts written"
                            :items="$mostActiveArray"/>
                </div>

                <div class="row">
                    <?php $mostActiveLastMonthArray = $mostActiveLastMonth->map(function ($el) {
                        return ['title' => $el->name, 'href' => '', 'count' => $el->posts_count];
                    });?>
                    <x-card title="Most Active Users Last Month"
                            subtitle="Writers with most posts written in the last month"
                            :items="$mostActiveLastMonthArray"/>
                </div>

        </div>

    </div>


@endsection
