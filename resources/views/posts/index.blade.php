@extends('layout')



@section('content')

    <div class="row">
        <div class="col-8">
            @forelse($posts as $post)
                <div class="mb-4">
                    <h3>
                        <a href="{{ route('posts.show',['post'=>$post->id]) }}">{{ $post->title }}</a>
                    </h3>

                    <p class="text-muted">
                        Added {{$post->created_at->diffForHumans() }}
                        by {{ $post->user->name }}
                    </p>

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

                    @can('delete', $post)
                        <form class="fm-inline" action="{{ route('posts.destroy',['post'=>$post->id]) }}" method="POST">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">DELETE</button>
                        </form>
                    @endcan

                </div>
            @empty
                <p>No blog posts yet!</p>
            @endforelse
        </div>

        <div class="col-4">
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Most Commented</h5>
                    <h6 class="card-subtitle mb-2 text-muted">What people are currently talking about.</h6>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($most_commented as $post)
                       <li class="list-group-item">
                           <a href="{{ route('posts.show',['post'=>$post->id]) }}">
                               {{ $post->title }}
                           </a>
                       </li>
                    @empty
                        <li class="list-group-item">No Posts with comments yet!</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

@endsection
