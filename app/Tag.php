<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    protected $fillable = ['name'];

    public function posts()
    {
//        return $this->belongsToMany(BlogPost::class)->withTimestamps();
        return $this->morphedByMany(BlogPost::class,'tagable')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class,'tagable')->withTimestamps();
    }

}
