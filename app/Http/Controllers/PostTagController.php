<?php

namespace App\Http\Controllers;

use App\BlogPost;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostTagController extends Controller
{

    public function index($tag)
    {

        $tag = Tag::with('posts')->findOrFail($tag);

        return view('posts.index',[
            'posts'=> $tag->posts,
            'mostCommented' => [],
            'mostActive' => [],
            'mostActiveLastMonth' => []
        ]);
//        $posts = Cache::tags(['tags-archive'])->remember('tags-archive',600,function() use($tagId){
//            return BlogPost::with('tags',function($query) use ($tagId){
//                return $query->where('blog_post_id',$tagId);
//            })->get();
//        });
    }
}
