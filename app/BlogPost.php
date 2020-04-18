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

    //HANDLING MODEL EVENTS
    public static function boot()
    {
        static::addGlobalScope(new DeletedAdminScope());
        parent::boot();


//        static::addGlobalScope(new LatestScope());    public static function boot()
//    {
//        parent::boot();
//
//        static::addGlobalScope(new DeletedAdminScope());
//    }

        //needed so as to perform soft delete on comments (although there already exists a cascade constraint)
        static::deleting(function(BlogPost $blogPost){
            $blogPost->comments()->delete();
        });

        static::updating(function(BlogPost $post){
            Cache::forget("blog-post-{$post->id}");
        });

        static::restored(function(BlogPost $blogPost){
            $blogPost->comments()->restore();
        });
    }

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

}
