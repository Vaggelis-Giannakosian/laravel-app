<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Http\Requests\StorePost;
use App\User;
use Illuminate\Support\Facades\Cache;

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

//        $posts = Cache::remember('posts',now()->addSecond(10),function(){
//            return BlogPost::latest()->withCount('comments')->with('user')->get();
//        });

        $mostCommented = Cache::remember('blog-post-most-commented',600,function(){
            return BlogPost::mostCommented()->take(5)->get();
        });
        $mostActive = Cache::remember('users-most-active',600,function(){
            return User::withMostBlogPosts()->take(5)->get();
        });
        $mostActiveLastMonth = Cache::remember('users-most-active-last-month',600,function(){
            return User::withMostPostsLastMonth()->take(5)->get();
        });

        return view(
            'posts.index',
            [
                'posts' => BlogPost::latest()->withCount('comments')->with('user')->get(),
                'mostCommented'=>$mostCommented,
                'mostActive' =>$mostActive,
                'mostActiveLastMonth' => $mostActiveLastMonth
            ]
        );
    }

    public function create()
    {
//        $this->authorize('posts.create');
        return view('posts.create');
    }

    public function store(StorePost $request)
    {
        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;
//        ($post = new BlogPost($validatedData))->save();

        $post = BlogPost::create($validatedData);
        request()->session()->flash('status','Blog post was created!');
        return redirect()->route('posts.show',['post'=>$post->id]);

    }


    public function show($id)
    {
        $post = Cache::remember("blog-post-$id",600,function() use($id){
            return BlogPost::with('user')->find($id);
        });
        $comments = Cache::remember("blog-post-$id-comments",600,function() use($post){
            return $post->comments()->with('user')->get();
        });

//        another way
//        $comments = BlogPost::with(['comments'=>function($query){
//            return $query->latest();
//        }])->findOrFail($post->id)->comments;

//        simpler way


        return view('posts.show', compact('post','comments'));
    }


    public function edit(BlogPost $post)
    {
//        dd(auth()->user()->can('update', $post));
        $this->authorize($post);
        return view('posts.edit',['post'=>$post]);
    }


    public function update(StorePost $request, BlogPost $post )
    {
        $this->authorize($post);
//        if(Gate::denies('update-post',$post))
//        {
//            abort(403, "You can't edit this post");
//        }

        $validatedData = $request->validated();
//        $post->update($validatedData);
        $post->fill($validatedData)->save();
        request()->session()->flash('status','Blog post was updated!');
        return redirect()->route('posts.show',['post'=>$post->id]);
    }


    public function destroy(BlogPost $post)
    {
        $this->authorize($post);

       $result = $post->delete();
//       $result = BlogPost::destroy($post->id);

        $flashMessage =  $result ? 'Blog post was deleted!' : 'There was an error. Please try again';
        request()->session()->flash('status',$flashMessage);
       return redirect()->route('posts.index');
    }
}
