<?php

namespace App\Http\Controllers;


use App\BlogPost;
use App\Comment;
use App\Http\Requests\StoreComment;


class PostCommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }


    public function store(StoreComment $request, BlogPost $post)
    {

        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
        $post->comments()->create($validatedData);

        request()->session()->flash('status','Comment was successfully added!');
        return redirect()->back();
    }
}
