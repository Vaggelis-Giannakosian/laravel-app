<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{

    use SoftDeletes;

    protected $fillable = ['title','content'];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    //HANDLING MODEL EVENTS
    public static function boot()
    {
        parent::boot();
        //needed so as to perform soft delete on comments (although there already exists a cascade constraint)
        static::deleting(function(BlogPost $blogPost){
            $blogPost->comments()->delete();
        });

        static::restored(function(BlogPost $blogPost){
            $blogPost->comments()->restore();
        });
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
