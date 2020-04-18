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

        $tag = Cache::tags(['blog-post'])->remember(
            "blog-tags-index-{$tag}",
            600,
            function () use ($tag) {
                return Tag::with(['posts', 'posts.user', 'posts.comments', 'posts.tags'])->findOrFail($tag);
            }
        );

        return view('posts.index',[
            'posts'=> $tag->posts
        ]);
    }
}
