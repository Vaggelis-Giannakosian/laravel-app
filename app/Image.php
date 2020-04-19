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

    public static function boot()
    {
        parent::boot();

        //needed so as to perform soft delete on comments (although there already exists a cascade constraint)
        static::deleting(function (Image $image) {
            Storage::delete($image->path);
        });

    }
}
