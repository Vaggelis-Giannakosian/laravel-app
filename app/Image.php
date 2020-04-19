<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $fillable = ['path','post_id'];

    public function post()
    {
        return $this->belongsTo(BlogPost::class,'blog_post_id');
    }

    public function url()
    {
       return Storage::url($this->path);
    }
}
