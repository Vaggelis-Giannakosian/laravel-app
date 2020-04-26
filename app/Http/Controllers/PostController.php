<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Events\BlogPostCreated;
use App\Http\Requests\StorePost;
use App\Image;
use App\Services\Counter;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth')->only(['create','edit','update','store','destroy']);
        $this->middleware('auth')->except(['index','show']);
    }

    public function index()
    {

        $posts = Cache::tags(['blog-post','blog-common'])->remember('blog-index',600,function(){
            return BlogPost::lastestWithRelations()->get();
        });

        return view(
            'posts.index',
            [
                'posts' => $posts
            ]
        );
    }


    public function show($id, Counter $counter)
    {
        $post = Cache::tags(['blog-post'])->remember("blog-post-$id",600,function() use($id){
            return BlogPost::with(['user','tags','comments','comments.user','thumb'])->find($id);
        });

        $comments = Cache::tags(['blog-post'])->remember("blog-post-$id-comments",600,function() use($post){
            return $post->comments()->with(['user','tags'])->get();
        });

        //        another way
//        $comments = BlogPost::with(['comments'=>function($query){
//            return $query->latest();
//        }])->findOrFail($post->id)->comments;

//        simpler way

        return view('posts.show', [
            'post'=>$post,
            'comments' => $comments,
            'counter' => $counter->update("blog-post-{$id}",['blog-post'])
        ]);
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
        $post = BlogPost::create($validatedData);

        if( $request->hasFile('thumbnail') )
        {
            $file = $request->file('thumbnail');
            $filename = $post->id.'_'.str_replace($file->getClientOriginalExtension(),$file->guessExtension(),$file->getClientOriginalName());
            $path = $file->storeAs('thumbnails',$filename);
            $post->thumb()->save(
                Image::make(['path'=>$path])
            );
        }

        event( new BlogPostCreated($post) );

        request()->session()->flash('status','Blog post was created!');
        return redirect()->route('posts.show',['post'=>$post->id]);

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
        $validatedData = $request->validated();
        $post->fill($validatedData)->update();

        if( $request->hasFile('thumbnail') )
        {
            $file = $request->file('thumbnail');
            $filename = $post->id.'_'.str_replace($file->getClientOriginalExtension(),$file->guessExtension(),$file->getClientOriginalName());
            $path = $file->storeAs('thumbnails',$filename);

            if($post->thumb)
            {
                Storage::delete($post->thumb->path);
                $post->thumb->path = $path;
                $post->thumb->save();
            }else{
                $post->thumb()->save(
                    Image::make(['path'=>$path])
                );
            }
        }

        request()->session()->flash('status','Blog post was updated!');
        return redirect()->route('posts.show',['post'=>$post->id]);
    }


    public function destroy(BlogPost $post)
    {
        $this->authorize($post);

       $result = $post->delete();
//       $result = BlogPost::destroy($post->id);

        $flashMessage =  $result ? 'Blog post was deleted!' : 'There was an error. Please try again';
        Cache::tags(['blog-common'])->flush();
        Cache::tags(['blog-post'])->forget("blog-post-{$post->id}");
        Cache::tags(['blog-post'])->forget("blog-post-{$post->id}-comments");
        request()->session()->flash('status',$flashMessage);
       return redirect()->route('posts.index');
    }
}
