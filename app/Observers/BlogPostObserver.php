<?php

namespace App\Observers;

use App\BlogPost;
use App\Comment;
use Illuminate\Support\Facades\Cache;

class BlogPostObserver
{
    /**
     * Handle the blog post "created" event.
     *
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function created(BlogPost $blogPost)
    {
        //
    }

    public function creating(BlogPost $blogPost)
    {
        Cache::tags(['blog-common'])->flush();
    }

    /**
     * Handle the blog post "updated" event.
     *
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function updated(BlogPost $blogPost)
    {

    }

    public function updating(BlogPost $blogPost)
    {
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        Cache::tags(['blog-post', 'blog-common'])->forget("blog-index");
        Cache::tags(['blog-post', 'blog-common'])->forget("blog-post-most-commented");
    }

    public function saving(BlogPost $blogPost)
    {
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        Cache::tags(['blog-post', 'blog-common'])->forget("blog-index");
        Cache::tags(['blog-post', 'blog-common'])->forget("blog-post-most-commented");
    }


    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //
    }


    public function deleting(BlogPost $blogPost)
    {
        //needed so as to perform soft delete on comments (although there already exists a cascade constraint)
        $blogPost->comments()->delete();
        $blogPost->thumb()->delete();
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        Cache::tags(['blog-post', 'blog-common'])->flush();
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        $blogPost->comments()->restore();
        Cache::tags(['blog-post'])->forget("blog-post-{$blogPost->id}");
        Cache::tags(['blog-post'])->forget("blog-index");
        Cache::tags(['blog-post'])->forget("blog-post-most-commented");
        Cache::tags(['blog-post'])->forget("users-most-active");
        Cache::tags(['blog-post'])->forget("users-most-active-last-month");
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        //
    }
}
