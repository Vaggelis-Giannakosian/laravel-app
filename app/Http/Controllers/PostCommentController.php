<?php

namespace App\Http\Controllers;


use App\BlogPost;
use App\Http\Requests\StoreComment;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use Illuminate\Support\Facades\Mail;


class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }


    public function store(StoreComment $request, BlogPost $post)
    {

        $comment = $post->comments()->create([
            'content' => request('content'),
            'user_id' => $request->user()->id,
        ]);

       Mail::to($post->user)->send( new CommentPostedMarkdown($comment) );

        return redirect()
            ->back()
            ->withStatus('Comment was successfully added!');
    }
}
