<?php

namespace App\Http\Controllers\Api\V1;

use App\BlogPost;
use App\Comment;
use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->only(['store','update','destroy']);
        $this->authorizeResource(Comment::class,'comment');
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(BlogPost $post, Request $request)
    {
        $perPage =  $request->input('per_page') ?? 3;

//        return response()->json(['comments'=>[]]);
        return CommentResource::collection(
            $post->comments()->with('user')->paginate($perPage)->appends([
                'per_page' => $perPage
            ])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreComment  $request
     * @param  \App\BlogPost  $post
     * @return \App\Http\Resources\Comment
     */
    public function store(BlogPost $post, StoreComment $request)
    {
        $comment = $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        event( new CommentPosted($comment) );

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogPost  $post
     * @param  \App\Comment  $comment
     * @return \App\Http\Resources\Comment
     */
    public function show(BlogPost $post, Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\BlogPost  $post
     * @param  \App\Comment  $comment
     * @param  \App\Http\Requests\StoreComment  $request
     * @return \App\Http\Resources\Comment
     */
    public function update(BlogPost $post, Comment $comment, StoreComment $request)
    {
        $comment->content = $request->input('content');
        $comment->save();

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogPost  $post
     * @param  \App\Comment  $comment
     */
    public function destroy(BlogPost $post, Comment $comment)
    {
        $comment->delete();

        return response()->noContent();
    }
}
