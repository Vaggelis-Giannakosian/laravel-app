<?php

namespace App\Http\Controllers;


use App\BlogPost;
use App\Events\CommentPosted;
use App\Http\Requests\StoreComment;
use App\Http\Resources\Comment as CommentResource;
use App\User;


class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function index(BlogPost $post){

        return CommentResource::collection($post->comments()->with('user')->get());
    }

    public function store(StoreComment $request, BlogPost $post)
    {
        $comment = $post->comments()->create([
            'content' => request('content'),
            'user_id' => $request->user()->id,
        ]);

        event( new CommentPosted($comment) );

        return redirect()
            ->back()
            ->withStatus('Comment was successfully added!');
    }
}
