<?php

namespace App;

use App\Scopes\DeletedAdminScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class BlogPost extends Model
{

    use SoftDeletes;

    protected $fillable = ['title','content','user_id'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function scopeOwn(Builder $query){
        return $query->where('user_id',auth()->user()->id);
    }

    public function scopeMostCommented(Builder $query)
    {
        return $query->withCount('comments')->orderBy('comments_count','desc');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->latest();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }



    //HANDLING MODEL EVENTS
    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope());
        parent::boot();


        //needed so as to perform soft delete on comments (although there already exists a cascade constraint)
        static::deleting(function(BlogPost $post){
            $post->comments()->delete();
            Cache::tags(['blog-post'])->forget("blog-post-{$post->id}");
            Cache::tags(['blog-post'])->forget("blog-index");
            Cache::tags(['blog-post'])->forget("blog-post-most-commented");
            Cache::tags(['blog-post'])->forget("users-most-active");
            Cache::tags(['blog-post'])->forget("users-most-active-last-month");
        });

        static::updating(function(BlogPost $post){
            Cache::tags(['blog-post'])->forget("blog-post-{$post->id}");
            Cache::tags(['blog-post'])->forget("blog-index");
            Cache::tags(['blog-post'])->forget("blog-post-most-commented");
        });

        static::restored(function(BlogPost $post){
            $post->comments()->restore();
            Cache::tags(['blog-post'])->forget("blog-post-{$post->id}");
            Cache::tags(['blog-post'])->forget("blog-index");
            Cache::tags(['blog-post'])->forget("blog-post-most-commented");
            Cache::tags(['blog-post'])->forget("users-most-active");
            Cache::tags(['blog-post'])->forget("users-most-active-last-month");

        });
    }



}
