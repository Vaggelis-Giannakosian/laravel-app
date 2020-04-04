<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;

class PostController extends Controller
{


    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::all()->sortByDesc("created_at")]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request->validate();
        $post = BlogPost::create($validatedData);
        request()->session()->flash('status','Blog post was created!');
        return redirect()->route('posts.show',['post'=>$post->id]);

    }


    public function show(BlogPost $post)
    {
        return view('posts.show', ['post' => $post]);
    }


    public function edit(BlogPost $post)
    {
        return view('posts.edit',['post'=>$post]);
    }


    public function update(StorePost $request,BlogPost $post )
    {
        dd($post);
    }


    public function destroy($id)
    {
        //
    }
}
