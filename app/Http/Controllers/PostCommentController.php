<?php

namespace App\Http\Controllers;


use App\BlogPost;
use App\Http\Requests\StoreComment;


class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }


    public function store(StoreComment $request, BlogPost $post)
    {

        $post->comments()->create([
            'content' => request('content'),
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->back()
            ->withStatus('Comment was successfully added!');
    }
}
