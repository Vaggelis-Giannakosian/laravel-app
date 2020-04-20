<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{

    use SoftDeletes;


    protected $fillable = ['content','user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class,'tagable')->withTimestamps();
    }

    public function commentable()
    {
        return $this->morphTo();
    }

    //HANDLING MODEL EVENTS
    public static function boot()
    {
        parent::boot();

        static::deleting(function(Comment $comment){
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}-comments");
            Cache::tags(['blog-post','blog-common'])->forget("blog-post-most-commented");
        });

        static::updating(function(Comment $comment){
            Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}-comments");
        });

        static::creating(function(Comment $comment){
            if($comment->commentable_type === BlogPost::class)
            {
                Cache::tags(['blog-post'])->forget("blog-post-{$comment->commentable_id}-comments");
                Cache::tags(['blog-post','blog-common'])->forget("blog-post-most-commented");
            }

        });

    }
}
