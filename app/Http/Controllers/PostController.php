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
        $validatedData = $request->validated();
//        ($post = new BlogPost($validatedData))->save();

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


    public function update(StorePost $request, BlogPost $post )
    {
        $validatedData = $request->validated();
//        $post->update($validatedData);
        $post->fill($validatedData)->save();
        request()->session()->flash('status','Blog post was updated!');
        return redirect()->route('posts.show',['post'=>$post->id]);
    }


    public function destroy(BlogPost $post)
    {
       $result = $post->delete();
//       $result = BlogPost::destroy($post->id);

        request()->session()->flash('status','Blog post was deleted!');

       if(!$result)
           request()->session()->flash('status','There was an error. Please try again');

       return redirect()->route('posts.index');
    }
}
