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

                <x-updated :date="$post->created_at" :name="$post->user->name" />

                    @if($post->comments_count)
                        <p>{{ $post->comments_count }} comments</p>
                    @else
                        <p>No comments yet!</p>
                    @endif


                    @can('update', $post)
                        <a class="btn btn-primary btn-sm" href="{{ route('posts.edit',['post'=>$post->id]) }}">Edit</a>
                    @endcan

                    {{--            @cannot('delete',$post)--}}
                    {{--                <p>You cant delete this post.</p>--}}
                    {{--            @endcannot--}}
                    {{--                --}}

                    @if(!$post->trashed())
                        @can('delete', $post)
                            <form class="fm-inline" action="{{ route('posts.destroy',['post'=>$post->id]) }}"
                                  method="POST">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">DELETE</button>
                            </form>
                        @endcan
                    @endif

                </div>
            @empty
                <p>No blog posts yet!</p>
            @endforelse
        </div>

        <div class="col-4">

            <div class="container"></div>


            <div class="row">

                <div class="card mb-4" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Commented</h5>
                        <h6 class="card-subtitle mb-2 text-muted">What people are currently talking about.</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($mostCommented as $post)
                            <li class="list-group-item">
                                <a href="{{ route('posts.show',['post'=>$post->id]) }}">
                                    {{ $post->title }} ({{ $post->comments->count() }})
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item">No Posts with comments yet!</li>
                        @endforelse
                    </ul>
                </div>

            </div>

            <div class="row">

                <div class="card mt-4" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Active Users</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Users with most posts written</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($mostActive as $user)
                            <li class="list-group-item">
                                {{ $user->name }} ({{ $user->posts_count }})
                            </li>
                        @empty
                            <li class="list-group-item">No Users found</li>
                        @endforelse
                    </ul>
                </div>

            </div>
            <div class="row">

                <div class="card mt-4" style="width: 100%">
                    <div class="card-body">
                        <h5 class="card-title">Most Active Users Last Month</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Users with most posts written in the last month</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($mostActiveLastMonth as $user)
                            <li class="list-group-item">
                                {{ $user->name }} ({{ $user->posts_count }})
                            </li>
                        @empty
                            <li class="list-group-item">No Users found</li>
                        @endforelse
                    </ul>
                </div>

            </div>


        </div>

    </div>


@endsection
