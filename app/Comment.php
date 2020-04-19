<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{

    use SoftDeletes;


    protected $fillable = ['content','user_id'];
    // blog_post_id
    //blogPost
    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //HANDLING MODEL EVENTS
    public static function boot()
    {
        parent::boot();

        static::deleting(function(Comment $comment){
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->blogPost->id}-comments");
            Cache::tags(['blog-post','blog-common'])->forget("blog-post-most-commented");
        });

        static::updating(function(Comment $comment){
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->blogPost->id}-comments");
        });

        static::creating(function(Comment $comment){
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->blogPost->id}-comments");
            Cache::tags(['blog-post','blog-common'])->forget("blog-post-most-commented");
        });

    }
}
