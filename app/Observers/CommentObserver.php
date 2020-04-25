<?php

namespace App\Observers;

use App\BlogPost;
use App\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        if($comment->commentable_type === BlogPost::class || $comment->commentable_type === Comment::class)
        {
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}-comments");
            Cache::tags(['blog-post','blog-common'])->forget("blog-post-most-commented");
        }
    }

    /**
     * Handle the comment "updated" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        //
    }

    public function updating(Comment $comment)
    {
        Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}-comments");
    }

    /**
     * Handle the comment "deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        //
    }


    public function deleting(Comment $comment)
    {
        //
    }

    /**
     * Handle the comment "restored" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}-comments");
        Cache::tags(['blog-post','blog-common'])->forget("blog-post-most-commented");
    }

    /**
     * Handle the comment "force deleted" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        //
    }

}
