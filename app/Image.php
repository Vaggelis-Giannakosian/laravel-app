<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['path','post_id'];

    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }
}
