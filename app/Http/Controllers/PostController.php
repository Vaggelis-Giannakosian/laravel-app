<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth')->only(['create','edit','update','store','destroy']);
        $this->middleware('auth')->except(['index','show']);
    }

    public function index()
    {
//        DB::connection()->enableQueryLog();
//        $posts = BlogPost::with('comments')->get();
//        foreach ($posts as $post) {
//            foreach ($post->comments as $comment) {
//                echo $comment->content;
//            }
//        }
//        dd(DB::getQueryLog());


        return view(
            'posts.index',
            [ 'posts' => BlogPost::withCount('comments')->get()->sortByDesc("created_at") ]
        );
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
        $comments = $post->comments()->orderBy('created_at', 'desc')->get();
        return view('posts.show', compact('post','comments'));
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

        $flashMessage =  $result ? 'Blog post was deleted!' : 'There was an error. Please try again';
        request()->session()->flash('status',$flashMessage);
       return redirect()->route('posts.index');
    }
}
