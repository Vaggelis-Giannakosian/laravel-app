<?php

namespace App\Http\Controllers;


use App\BlogPost;
use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersPostWasCommented;
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

//        sends immediately
//       Mail::to($post->user)->send( new CommentPostedMarkdown($comment) );

        //sends after specific time interval
//        $when = now()->addMinutes(1);
//       Mail::to($post->user)->later($when, new CommentPostedMarkdown($comment) );

        Mail::to($post->user)->queue( new CommentPostedMarkdown($comment) );

        NotifyUsersPostWasCommented::dispatch($comment);

        return redirect()
            ->back()
            ->withStatus('Comment was successfully added!');
    }
}
