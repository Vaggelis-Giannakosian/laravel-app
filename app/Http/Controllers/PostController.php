<?php

namespace App\Http\Controllers;

use App\BlogPost;
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

    public function store(Request $request)
    {
        $post = new BlogPost();
        $post->title = request()->input('title');
        $post->content = request()->input('content');
        $post->save();

        request()->session()->flash('status','Blog post was created!');

        return redirect()->route('posts.show',['post'=>$post->id]);

    }


    public function show($id)
    {
        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
